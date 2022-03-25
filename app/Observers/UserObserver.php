<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user){
	if(empty($user->avatar)){
	    $user->avatar = 'http://bbs.sinmu.ltd/uploads/images/avatars/202203/18/1_1647595580_waRu1IerSk.jpg';
	}
    }
}
