<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as PostResource;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRating(User $user, Post $post) {
        if($user->ratings->find($post->id)) {
            return $user->ratings->find($post->id)->pivot->rating;
        } else {
            return 0;
        }
    }

    public function updateRating() {
        $post_id = request()->input('post_id');
        $rating = request()->input('rating');

        $post = Post::find($post_id);
        $post->rating += $rating;
        $post->save();

        $userRating = 0;
        if(Auth::user()->ratings->find($post_id)) {
            $userRating = Auth::user()->ratings->find($post_id)->pivot->rating;
        }
        $userRating += $rating;
        Auth::user()->ratings()->syncWithoutDetaching([
            $post_id => [ 'rating' => $userRating]
            ]);
        
        return $post;
    }
}
