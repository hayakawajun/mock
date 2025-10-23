<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        Comment::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'item_id' => $request->item_id
            ],
            [
                'text' => $request->text
            ]
        );

        return redirect()->route('item.show',['id' => $request->item_id])->with('success','新しいコメントを投稿しました');
    }
}
