@extends('layouts.app')

@section('content')
    <form action="/api/posts" method="POST">
        <input type="text" name="title">
        <input type="text" name="slug">
        <input type="file" name="slug_image">
        <input type="text" name="text">
        <input type="text" name="categories[]">
        <input type="submit" name="submit" value="Odoslat">

    </form>
@endsection