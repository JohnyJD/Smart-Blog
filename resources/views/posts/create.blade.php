<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create a post</title>
</head>
<body>
    <h2>Create a new post</h2>
    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <input type="text" name="title">
            @error('title')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <textarea name="slug" cols="30" rows="5"></textarea>
            @error('slug')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <textarea name="text" cols="30" rows="30"></textarea>
            @error('text')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <input type="file" name="slug_image">
            @error('slug_image')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <input type="input" name="categories[]">
            @error('categories.0')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <input type="input" name="categories[]">
            @error('categories.1')<p>{{ $message }}</p>@enderror
        </div>
        <div>
            <button>Add post</button>
        </div>
    </form>
</body>
</html>