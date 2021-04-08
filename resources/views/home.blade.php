@extends('layouts.app')

@section('content')
    @auth
        <app-component :user="{{ Auth::user() }}"></app-component>
    @endauth
@endsection
