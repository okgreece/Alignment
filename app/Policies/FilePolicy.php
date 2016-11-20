<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;

use App\File;

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
        if(count($file->projects)==0){
            return $user->id === $file->user_id;
        }
        else{
            return false;
        }
        
    }
}
