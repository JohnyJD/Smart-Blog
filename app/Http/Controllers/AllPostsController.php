<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Resources\Post as PostResource;

class AllPostsController extends Controller
{
    public function index() {
        return PostResource::collection(Post::with('categories', 'user', 'comments')->get());
    }

    public function show(Post $post) {
        $post->update([
           'views' => $post->views+1
        ]);
        return new PostResource($post->load('categories', 'user', 'comments.user'));
    }

    public function postsByCategory($categoryName) {
        if($categoryName) {
            if(Category::where("name", "=", $categoryName)) {
                return PostResource::collection(Category::where("name", "=", $categoryName)->first()->posts()->with('categories', 'user', 'comments')->get());
            }
        }
        return "Nothing found";
    }
}
