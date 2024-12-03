<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy
{
    public function update(User $user, Reply $reply)
    {
        // Example: Only the owner of the reply can update it
        return $reply->user_id === $user->id;
    }

    public function delete(User $user, Reply $reply)
    {
        // Allow only the owner of the reply to delete it
        return $reply->user_id === $user->id;
    }
}