<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\UserChild;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{




    public function tree_child_setter(){
        // wrapper for tree child setter


    function user_finder(){
               $users = User::all();

                 foreach($users as $user){
                 
                    $left_store_users = [];
                    $right_store_users = [];
                    $uls = User::where('pos_id', $user->id)->where('position',1)->first();
          
                    $urs = User::where('pos_id', $user->id)->where('position',2)->first();
                    if($uls){
                        
                        $left_store_users =  userSc($uls->id);
                    }
                    
                   if($urs){
                   
                    $right_store_users =  userSc($urs->id);
                   }
                    


                    $left_store_users = getThingTo($left_store_users);

                    if($uls){
                        array_unshift($left_store_users, $uls->id);
                    }

                    $right_store_users = getThingTo($right_store_users);

                    if($urs){
                        array_unshift($right_store_users, $urs->id);
                    }


                    $lc = 0;
                    $rc = 0;

                    if(count($left_store_users) != 0){
                         foreach($left_store_users as $v){
                           $ulc = User::where('id', $v)->first();
                        if($ulc){
                           $lc++;
                            }
                        }
                    }

                    $lulist = $user->id."->".count($left_store_users)."==".$lc;


                    
                    if(count($right_store_users) != 0){
                         foreach($right_store_users as $v){
                        $urc = User::where('id', $v)->first();
                        if($urc){
                           $rc++;
                            }
                        }
                    }

                    $rulist = $user->id."->".count($right_store_users)."==".$rc;


                    $userChild = UserChild::where('user_id',$user->id)->first();
                    $userChild->user_l = json_encode($left_store_users);
                    $userChild->user_r = json_encode($right_store_users);
                    $userChild->save();
                      
                   echo "<pre>";
                  echo  "left -".$lulist;
                  echo  "right -".$rulist;
                   
                   echo "</pre>";
                  
                }
               
        }


user_finder();
    
    // end section for tree child setter
    }







public function run()
{
    while (true) {
        try {
            $this->runQueueWorker();
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
        }
    }
}

protected function runQueueWorker()
{
    $exitCode = Artisan::call('queue:work', [
        '--tries' => 1,
    ]);

    if ($exitCode !== 0) {
        $this->restartQueueWorker();
    }
}

protected function restartQueueWorker()
{
    // Restart the queue worker by calling the Artisan command again
    $kernel = app(Kernel::class);
    $kernel->call('queue:restart');
}
}
