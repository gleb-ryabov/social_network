<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\CommentServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CommentController extends Controller
{

    // Services Layer for showAll
    protected $commentServices;
    public function __construct(CommentServices $commentServices)
    {
        $this->commentServices = $commentServices;
    }

    /**
     * Display all comments
     */
    public function showAll($id)
    {
        $comments = $this->commentServices->getCommentsForUser($id);
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
