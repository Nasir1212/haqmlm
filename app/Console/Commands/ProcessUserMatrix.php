<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserExtra;
use App\Models\MatrixLevel;
use App\Models\User;

class ProcessUserMatrix extends Command
{
    protected $signature = 'user:process-matrix';
    protected $description = 'Process user matrix and update UserExtra records in chunks';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting user matrix processing...');

        $setting = setting();
        $level = $setting->matrix_gen_check;
        $total_member = $setting->set_gen_member;

        $userIds = UserExtra::pluck('user_id');
        $userIdsArray = $userIds->toArray();

        $originalArray = $userIdsArray;
        $elementsToMove = [];
        
        // Truncate UserExtra table
        UserExtra::truncate();

        $lv = "lv_" . $level;

        foreach ($originalArray as $user) {
            $check_level = MatrixLevel::where('user_id', $user)->first();
            if ($check_level) {
                $data = json_decode($check_level->$lv);
                if (count($data) == $total_member) {
                    $elementsToMove[] = $user;
                }
            }
            
            if ($user == 1) {
                $u = User::find(1);
                $extra = new UserExtra();
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
            
            matrixLUpdate($user);
        }

        $remainingElements = array_diff($originalArray, $elementsToMove);
        $rearrangedArray = array_merge($remainingElements, $elementsToMove);

        $this->processUsersInChunks($rearrangedArray);

        $this->info('User matrix processing completed.');
    }

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
