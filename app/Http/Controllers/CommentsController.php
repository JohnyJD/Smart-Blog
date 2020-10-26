<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends Controller
{

    public function store()
    {
        Auth::user()->comments()->create($this->validateData());

        return response([], Response::HTTP_CREATED);
    }

    public function update(Comment $comment)
    {
        if(request()->user()->isNot($comment->user)) {
            return response([], 403);
        }
        $comment->update($this->validateData());
        return response([], Response::HTTP_OK);
    }

    public function delete(Comment $comment)
    {
        if(request()->user()->isNot($comment->user)) {
            return response([], 403);
        }
        $comment->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }

    public function validateData()
    {
        return request()->validate([
            'text' => 'required',
            'post_id' => 'required'
        ]);
    }
}
