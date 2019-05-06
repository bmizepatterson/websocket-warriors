@extends('layout.base')

@section('title', 'Websocket Warriors')

@section('content')
    <div class="text-center p-5">
        <h1 class="display-1">Websocket Warriors</h1>
        <a class="btn btn-light" href="{{ route('app') }}">Join the Game</a>
    </div>
@endsection