@extends('layouts.app')

@section('content')
    <Authorized_app :user="@guest NULL @else {{ Auth::user() }} @endguest"></Authorized_app>
@endsection