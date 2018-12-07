<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentFormRequest;
use App\Comment;

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
    
    public function newComment(CommentFormRequest $request)
    {
        $comment = new Comment(array(
            'post_id' => $request->get('post_id'),
            'content' => $request->get('content'),
            'user_id' => auth()->user()->id
        ));

        $comment->save();

        return redirect()->back()->with('status', 'Your comment has been created!');
    }
}
