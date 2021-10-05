<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\models\Comment;
use App\models\Content;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Requested;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	// post new timeline content comment
	public function newComment(Requested $request)
	{
		$this->validate($request, [
			'comment' => 'required',
			'content_id' => 'required',
		]);
		// create new comment and capture user input
		$comment = new Comment;
		$comment->content_id = $request->content_id;
		$user = auth()->user();
		$comment->user_id = $user->id;
		$comment->comment = $request->comment;
		$comment->is_approved = 1;
		$comment->save();
		
		return back()->withInput();
	}
	// Delete comment
	public function deleteComment(Comment $comment, User $user)
	{
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			return back();
		}
		Comment::find($comment->id)->delete();
		
		return back();
	}
}
