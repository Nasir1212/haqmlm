<?php

namespace App\Services;

use App\Models\UserExtra;

class UserTreeService
{
    /**
     * Retrieve hierarchical user list.
     *
     * @return array
     */
    public function getHierarchicalUsers()
    {
        // Fetch all users ordered by post_id and position
        $users = UserExtra::orderBy('pos_id')->orderBy('position')->get();

        // Initialize result array
        $result = [];

        // Build the hierarchy
        $this->buildHierarchy($users, $result, 1);

        return $result;
    }

    /**
     * Recursively build the hierarchy.
     *
     * @param \Illuminate\Support\Collection $users
     * @param array $result
     * @param int $parentPostId
     * @return void
     */
    protected function buildHierarchy($users, &$result, $parentPostId)
    {
        // Filter users based on the parent post_id
        $currentLevelUsers = $users->filter(function ($user) use ($parentPostId) {
            return $user->pos_id == $parentPostId;
        });

        foreach ($currentLevelUsers as $user) {
            // Add user to result list
            $result[] = $user->user_name;

            // Recursively build children
            $this->buildHierarchy($users, $result, $user->position);
        }
    }
}
