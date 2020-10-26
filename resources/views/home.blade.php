@extends('layouts.app')

@section('content')
    <App :user="@guest null @else {{ Auth::user() }} @endguest"></App>
@endsection
