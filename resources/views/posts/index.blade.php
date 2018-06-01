@extends('layouts.app')

@section('content')
  @include('inc.sidebar')
  <div class="col-lg-8 col-md-10 mt-3">
    <div class="card mb-3">
      @include('inc.status')
    </div>
    <?php
      if(Auth::user()->gender === 'male'){
        $gen = 'Mr. ';

      }
      else{
        $gen = 'Ms. ';
      }
      $user = Auth::user()->first_name.' '.Auth::user()->last_name;
      $Fulluser = $gen.$user;
    ?>
    <?php
      $plist1 = App\Friend::where('to_id', '=', Auth::id())->where('status', '=', 'accepted')->pluck('from_id');
      $plist2 = App\Friend::where('from_id', '=', Auth::id())->where('status', '=', 'accepted')->pluck('to_id');
      $poserwithfriends = App\User::whereIn('id', $plist1)->orWhereIn('id', $plist2)->orWhere('id', '=', Auth::id())->pluck('id');
      $posts = App\Post::whereIn('user_id', $poserwithfriends)->where('type', '=', 'post')->orderBy('created_at', 'desc')->get();
    ?>
    @if(count($posts) > 0)
      @foreach($posts as $post)
        @include('inc.showposts')
      @endforeach
    @else
      <div class="mb-4 text-light">
        <h3>Welcome to Frienzzer, {{$Fulluser}}</h3>
        <h5>Why not start your journey by Customizing your Profile, Making new Friends or Sharing your Story?</h5>
      </div>
    @endif
  </div>
  @include('inc.rightsidebar')
@endsection
