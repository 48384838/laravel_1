<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Mail\CommentPosted;
use Mail;

class CommentController extends Controller
{
    //入力フォーム画面

    public function showForm()
    {
        return view('auth/form');
    }
    //入力を受け付ける。
    public function create(Request $request)
    {
        $user = Auth::user();
        $comment = new Comment(['body' => $request->comment]);

        $user->comments()->save($comment);

        Mail::to($user)->queue(new CommentPosted($user, $comment));

        //ここでメール送る
        return redirect()->route('comment.thanks');
    }

    public function thanks()
    {
        $comment = Auth::user()
            ->comments()
            ->orderby('id', 'desc')
            ->first();

        return view('auth/thanks', compact('comment'));
    }
}
