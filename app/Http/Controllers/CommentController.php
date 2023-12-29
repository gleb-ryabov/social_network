<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CommentController extends Controller
{

    /**
     * Display all comments.
     */
    public static function showAll($id)
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
        return view("profile.partials.all-comments-for-show", compact("comments"));
    }

    /**
     * Display one comment.
     */
    public static function showComment($id)
    {
        $comment = Comment::where("comments.id", $id)
            ->where("deleted_at", null)
            ->with('userAuthor')
            ->orderBy('comments.id', 'desc')
            ->first();
        return $comment;
    }

    /**
     * Create comment.
     */
    public function create()
    {
        $id_from = auth()->id();
        $data = request()->validate([
            'id_parent' => 'integer',
            'id_to' => 'integer',
            'name' => 'string',
            'comment' => 'string',
        ]);
        $data['id_from'] = $id_from;
        Comment::create($data);
        return Redirect::route('profile.show', $data['id_to']);
    }

    /**
     * Delete comment.
     */
    public function destroy(Comment $comment)
    {
        $id_account = $comment->id_to;
        $comment->delete();
        return Redirect::route('profile.show', $id_account);
    }
}
