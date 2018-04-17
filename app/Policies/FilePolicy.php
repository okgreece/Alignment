<?php

namespace App\Policies;

use App\File;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, File $file)
    {
        if (count($file->projects) == 0) {
            return $user->id === $file->user_id;
        } else {
            return false;
        }
    }
}
