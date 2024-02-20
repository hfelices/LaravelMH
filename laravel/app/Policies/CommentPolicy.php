<?php

namespace App\Policies;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(): bool
    {
        return true;
    }

     /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return ($user->role_id == 3 || $user->id == $comment->user_id);
    }

}
