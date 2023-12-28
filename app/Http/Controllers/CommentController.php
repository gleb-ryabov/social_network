<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class CommentController extends Controller
{

    /**
     * Display 5 user's comments.
     */
    public static function show($id)
    {
        $comments = Comment::where("id_to", $id)
            ->where("deleted_at", Null)
            ->with('userAuthor')
            ->orderBy('comments.id', 'desc')
            ->limit(5)
            ->get();
        return $comments;
    }

    /**
     * Display all comments.
     */
    public static function showAll($id)
    {
        $comments = Comment::where("id_to", $id)
            ->where("deleted_at", Null)
            ->with('userAuthor')
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
            ->where("deleted_at", Null)
            ->with('userAuthor')
            ->orderBy('comments.id', 'desc')
            ->first();
        return $comment;
    }

    /**
     * Count of user's comments
     */
    public static function showCount($id)
    {
        $comments_count = Comment::where('id_to', $id)
            ->where('deleted_at', null)
            ->count();
        return $comments_count;
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
