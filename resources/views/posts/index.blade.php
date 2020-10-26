<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
</head>
<body>
    <div class="body">
        <h1>Posts</h1>
        <a href="/posts/create">Create a post</a>
        @forelse($posts as $post)
            <a href="/posts/{{ $post->id }}"><h2>{{$post->title}}</h2></a>
            <p>{{ $post->slug }}</p>
            <img src="{{ asset('storage/' . $post->slug_image) }}">
            <ul>
                @foreach($post->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        @empty
            <p>No posts found</p>
        @endforelse
    </div>
</body>
</html>