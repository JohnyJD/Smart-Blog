<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit the post</title>
</head>
<body>
    <form action="/posts/{{ $post->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <input type="text" name="title" value="{{ $post->title }}">
            @error('title')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <textarea name="slug" cols="30" rows="5">{{ $post->slug }}</textarea>
            @error('slug')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <textarea name="text" cols="30" rows="30">{{ $post->text }}</textarea>
            @error('text')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <input type="file" name="slug_image" value="{{ $post->slug_image }}">
            @error('slug_image')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <input type="input" name="categories[]" value="{{ $post->categories[0]->name }}">
            @error('categories.0')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <input type="input" name="categories[]" value="{{ $post->categories[1]->name }}">
            @error('categories.1')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <button>Edit post</button>
        </div>
        @method('PATCH')
    </form>
</body>
</html>