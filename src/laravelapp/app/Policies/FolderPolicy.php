<?php

namespace App\Policies;

use App\Folder;
use App\Models\User;


class FolderPolicy
{
    /**
     * Create a new policy instance.
     * フォルダの閲覧権限
     * @param User $user
     * @param Folder $folder
     * @return bool
     */

    public function view(User $user, Folder $folder)
    {
        return $user->id === $folder->user_id;
    }
}
