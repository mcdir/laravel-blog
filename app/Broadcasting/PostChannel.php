<?php

namespace App\Broadcasting;

use App\Models\Post;
use App\Models\User;

class PostChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function join(User $user, Post $post): bool
    {
        return true;
    }
}
