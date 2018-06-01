@extends('layouts.app')

@section('content')
  <div class="flex-center position-ref full-height">
    <div class="content">
      @guest
        <div class="title m-b-md">
          {{ config('app.name', 'FRIENZZER') }}
        </div>
      @else
        <div class="title m-b-md">
          {{ __('Welcome to Frienzzer') }}
        </div>
      @endguest
      <div class="links">
        @guest
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}">Signup</a>
        @else
          <a href="/posts">Home</a>
        @endguest
      </div>
    </div>
  </div>
@endsection
