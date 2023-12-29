<?php

namespace App\Services;

use App\Models\Comment;

class CommentServices
{
    /**
     * Returns all comments about the user
     *
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public function getCommentsForUser($id)
    {
        $comments = Comment::select('users.*', 'comments.*', 'parent_comment.comment as parent_comment',
            'parent_comment.id_from as parent_author', 'parent_comment.deleted_at as parent_delete',
            'parent_user.email as parent_email')
            ->leftJoin('users', 'comments.id_from', '=', 'users.id')
            ->leftJoin('comments as parent_comment', 'parent_comment.id', '=', 'comments.id_parent')
            ->leftJoin('users as parent_user', 'parent_user.id', '=', 'parent_comment.id_from')
            ->where('comments.id_to', $id)
            ->where('comments.deleted_at', null)
            ->orderBy('comments.id', 'desc')
            ->get();

        return $comments;
    }
}
