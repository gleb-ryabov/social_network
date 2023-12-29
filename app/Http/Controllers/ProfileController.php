<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    /**
     * Display the list of user.
     */
    public static function index()
    {

        $users = User::all();

        return view("profile.index", compact("users"));
    }

    /**
     * Display the comments about user.
     */
    public function show($id)
    {

        $user = User::findOrFail($id);

        // Comments about user
        $comments = User::select('users.*', 'comments.*', 'parent_comment.comment as parent_comment',
            'parent_comment.id_from as parent_author', 'parent_comment.deleted_at as parent_delete',
            'parent_user.email as parent_email')
            ->leftJoin('comments', 'comments.id_from', '=', 'users.id')
            ->leftJoin('comments as parent_comment', 'parent_comment.id', '=', 'comments.id_parent')
            ->leftJoin('users as parent_user', 'parent_user.id', '=', 'parent_comment.id_from')
            ->where('comments.id_to', $id)
            ->where('comments.deleted_at', null)
            ->orderBy('comments.id', 'desc')
            ->get();
        // Count of comments about user
        $comments_count = $comments->count();
        // Slicing up to 5 comments
        $comments = $comments->take(5)->all();

        return view("profile.show", compact("user", "comments", "comments_count"));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
