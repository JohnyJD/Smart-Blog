<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Filesystem\Filesystem;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $this->authorize('viewAny', Post::class);
        return PostResource::collection(Auth::user()->posts()->with('categories', 'user', 'comments')->get());
    }

    public function create() {
        return view('posts.create');
    }

    public function store()
    {
        $this->authorize('create', Post::class);

        $post = Auth::user()->posts()->create($this->validateData(true));
        $categories = $this->validateCategories();
        $categoriesIDs = $this->getCategories($categories);
        $post->categories()->sync($categoriesIDs);
        $this->storeImage($post);

        return response([], Response::HTTP_CREATED);
    }

    public function show(Post $post) {
        $this->authorize('view', $post);
        return new PostResource($post->load('categories', 'user', 'comments.user'));
    }

    public function postComments(Post $post) {
        return $post->comments()->with('user')->get();
    }

    public function edit(Post $post) {
        $this->authorize('view', $post);
        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(Post $post)
    {
        $this->authorize('update', $post);

        $post->update($this->validateData(false));

        $categories = $this->validateCategories();
        $categoriesIDs = $this->getCategories($categories);
        $post->categories()->sync($categoriesIDs);

        if(request()->slug_image != null) {
            $this->deleteSlugImage($post);
            $this->storeImage($post);
        }

        return response([], Response::HTTP_OK);
    }

    public function delete(Post $post)
    {
        //$this->authorize('delete', $post);

        $post->delete();
        $this->deleteSlugImage($post);
        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData($slugImageRequired)
    {
        $requirement =  $slugImageRequired ? 'required' : 'nullable';
        request()->validate([
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'required|string|distinct',
            'slug_image' => $requirement . '|file|image'
        ]);
        return request()->validate([
            'title' => 'required',
            'text' => 'required',
            'slug' => 'required'
        ]);
    }

    private function getCategories($categories)
    {
        $categoriesIDs = [];
        foreach ($categories['categories'] as $category) {
            $categoriesIDs[] = (Category::firstOrCreate(['name' => $category]))->id;
        }
        return $categoriesIDs;
    }


    private function validateCategories()
    {
        return request()->validate(['categories' => 'required|array']);
    }

    private function storeImage($post)
    {
        $dest = public_path('/storage/slug_images/');
        $img = request()->file('slug_image');
        $image_name = Str::random(16) .'.'.$img->extension();
        $image = Image::make($img->path());
        $image->resize(1000, 600)->save($dest . $image_name);
        $post->update([
            'slug_image' => ('slug_images/' . $image_name)
            //'slug_image' => request()->slug_image->store('slug_images', 'images')
        ]);
        // for testing only
        //$_SESSION['testing'] = $post->slug_image;
    }

    private function deleteSlugImage(Post $post)
    {
        Storage::disk('public')->delete('slug_images', $post->slug_image);
        //Storage::disk('images')->delete('slug_images', $post->slug_image);
    }
}
