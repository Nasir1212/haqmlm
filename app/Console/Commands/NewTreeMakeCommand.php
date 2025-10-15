<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserExtra;
use App\Models\MatrixLevel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Jobs\BonusBulkSenderJob;

class NewTreeMakeCommand extends Command
{
    // Define the name and signature of the console command
    protected $signature = 'tree:make';

    // Define the command description
    protected $description = 'Rearrange users into matrix tree based on given levels and move filled members';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
       
    $setting = setting();
    $level = $setting->matrix_gen_check; // Get the current matrix level
    $total_member = $setting->set_gen_member; // Set the total number of members in a generation
    
    // Fetch all user_ids from UserExtra
    $userIds = UserExtra::pluck('user_id')->toArray();
    $originalArray = $userIds; // Original array of user IDs
    $elementsToMove = []; // Elements to be moved to the end of the array

    // Truncate the UserExtra table
    UserExtra::truncate();

    $lv = "lv_" . $level;
    foreach ($originalArray as $key => $user) {

    $current_user = User::where('id',$user)->first();

        // Fetch the user's level data from MatrixLevel
        $check_level = MatrixLevel::where('user_id', $user)->first();

        
        $another_check = 0;
        if ($check_level) {
            $data = json_decode($check_level->$lv);
            if (count($data) == $total_member) {
                $elementsToMove[] = $user; // Mark users with full levels to be moved
              
            }else{
                $another_check = 1;
            }
        }else{
            $another_check = 1;
        }
        
        if($another_check == 1){
         
            if ( $current_user && $current_user->submit_check == 0) {
                $elementsToMove[] = $user; // Mark users with not submit point  to be moved
             
            }
        }
    

       // Check if the user is the root user (ID=1)
        if ($user == 1) {
            $u = User::find(1); // Fetch user with ID=1
            $extra = new UserExtra(); // Create new UserExtra entry
            $extra->user_id = $user;
            $extra->fill_check = 0;
            $extra->root_level = 1;
            $extra->level_cap = 1;
            $extra->left = 0;
            $extra->middle = 0;
            $extra->right = 0;
            $extra->rank = 0;
            $extra->pos_id = 0;
            $extra->position = 0;
            $extra->parent_id = 0;
            $extra->user_name = $u->username;
            $extra->save();
        }

      //  Update matrix level for the user
       matrixLUpdate($user);
    }

    // Separate the elements to move and the rest
    $remainingElements = [];
    $movingElements = [];

   // Iterate through the original array to collect elements
    foreach ($originalArray as $element) {
        if (in_array($element, $elementsToMove)) {        
            $movingElements[] = $element; // Collect elements to move
        } else {
            $remainingElements[] = $element; // Collect remaining elements      

        }
    }

    
    // Merge remaining elements and moving elements  
    $rearrangedArray = array_merge($remainingElements, $movingElements);
   processUsersInChunks($rearrangedArray);
           BonusBulkSenderJob::dispatch();
        $this->info('Tree structure has been successfully updated.');
    }

    /**
     * Process users in chunks and auto-generate matrix.
     *
     * @param array $users
     * @param int $chunkSize
     */
    protected function processUsersInChunks(array $users, $chunkSize = 100)
    {
        foreach (array_chunk($users, $chunkSize) as $userChunk) {
            foreach ($userChunk as $user) {
                if ($user != 1) {
                    autoMatrixGenerator($user);
                }
            }
        }
    }
}
