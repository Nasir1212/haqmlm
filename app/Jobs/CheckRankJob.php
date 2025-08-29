<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\RankCondition;
use Illuminate\Support\Facades\DB;

class CheckRankJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
          // 1. পুরোনো rank data clear করা
DB::table('user_ranks')->truncate();
$users = User::select('id','ref_id','username')->get(); 
$cond = RankCondition::all(); 
$childrenMap = $users->groupBy('ref_id');
$my_rank = [];
$shift = [];
$my_rank[$cond->first()->rank_name] = collect();

$SDC = floor($cond->first()->down_check/2);// StmdDownCheck
 foreach($users as $user){
$counts =   RefCountLeftRight($user->id,$users);
// echo $user->username. " L : ".$counts['left']." R: ".$counts['right'] ."  </br>";
if($counts['left'] >= $SDC && $counts['right'] >= $SDC ){
$my_rank[$cond->first()->rank_name]->push($user->id);

}
 }

 $rankOrder = $cond->pluck('rank_name')->toArray();

 for($i = 1; count($rankOrder) > $i; $i++){

$preR = $rankOrder[$i-1];
$currR = $rankOrder[$i];
$my_rank[$currR] = collect();
$down_check = floor( $cond->where('rank_name',$currR)->value('down_check')/2);
foreach($users as $user){
//$children =  $users->where('ref_id', $user->id)->values();
$children =  $childrenMap[$user->id] ?? collect();
if($children->count() >= 2){
$leftHas = $my_rank[$preR]->contains($children[0]->id);
$rightHas = $my_rank[$preR]->contains($children[1]->id);

if($leftHas && $rightHas){
    if (!isset($shift['left'][$user->id]))  $shift['left'][$user->id] = [];
    if (!isset($shift['right'][$user->id]))  $shift['right'][$user->id] = [];
    

    foreach($childrenMap[ $children[0]->id] ??[] as $child){
         $childId = $child->id;
        if(in_array($childId, $my_rank[$preR]->toArray())){
           
            $shift['left'][ $user->id][] = $childId;
           if(!in_array($children[0]->id, $shift['left'][$user->id] )) $shift['left'][$user->id][] = $children[0]->id;
        }

    }

     foreach($childrenMap[ $children[1]->id] ??[] as $child){
        $childId = $child->id;
        if(in_array($childId, $my_rank[$preR]->toArray())){
            
             $shift['right'][$user->id][] =$childId;
                 if(!in_array($children[1]->id, $shift['right'][$user->id] )) $shift['right'][$user->id][] = $children[1]->id; 

        }

    }


  
    if( count($shift['left'][ $user->id]) >= $down_check  && count($shift['right'][$user->id] ) >= $down_check  ){
     $my_rank[$currR]->push($user->id)  ;
     $my_rank[$preR] =  $my_rank[$preR]->diff($my_rank[$currR]);
    }
} 
}

}

 }


  // 3. নতুন রেজাল্ট DB তে সেভ করুন
        foreach ($my_rank as $rankName => $ids) {
            foreach ($ids as $uid) {
                DB::table('user_ranks')->insert([
                    'user_id' => $uid,
                    'rank'    => $rankName,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

// foreach ($my_rank as $rankName => $ids) {
//     echo "$rankName: " . implode(', ', $ids->toArray()) . "<br/>";
// }
// echo "<pre>";
// print_r($shift);
// echo "</pre>";  

    }
}
