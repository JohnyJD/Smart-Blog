<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Smart blog</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <div class="flex-center">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <div class="body">
            <h1>Posts</h1>
            @forelse($all_posts as $post)
                <h2>{{$post->title}}</h2>
                <p>{{ $post->slug }}</p>
                <p>{{ $post->text }}</p>
                <img src="{{ asset('storage/' . $post->slug_image) }}">
                <ul>
                @foreach($post->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
                </ul>
                <h3>Autor : {{$post->user->name}}</h3>
            @empty
                <p>No posts found</p>
            @endforelse
        </div>
    </body>
</html>
