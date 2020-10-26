<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Post</h1>
    <h2>{{$post->title}}</h2>
    <p>{{ $post->text }}</p>
    <img src="{{ asset('storage/' . $post->slug_image) }}">
    <br><a href="/posts/{{ $post->id }}/edit">Edit</a>
    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        <button>Delete</button>
        @method('DELETE')
    </form>
</body>
</html>