@extends('layouts.app')

@section('content')
  <div class="col-lg-10 col-md-10">
    <div class="card mb-5" style="height: 250px; top: -1px;">
      <!-- Identify Profile-->
      <?php
        $url = $_SERVER['REQUEST_URI'];
        $trimurl = explode('/',$url,-1);
        $page = $trimurl[1];
        $id = $trimurl[2];
        $prouser = App\User::find($id);

        $f1 = App\Friend::where('from_id', '=', Auth::id())->where('to_id', '=', $prouser->id)->get();
        $f2 = App\Friend::where('to_id', '=', Auth::id())->where('from_id', '=', $prouser->id)->get();
        if((count($f1)+count($f2)) > 0){
          $alreadyfnd = true;
        }
        else{
          $alreadyfnd = false;
        }

        if($prouser->id == Auth::id()){
          $alreadyfnd = true;
        }
      ?>

      <!-- Change Cover pic-->
      <div class="coveredit">
        <?php
          if($prouser->cover_pic){
            $covermed = App\Media::find($prouser->cover_pic);
            $coverpic = '/storage/images/'.$covermed->url;
          }
          else{
            $coverpic = '/images/cover_pic.jpg';
          }
        ?>
        @if($prouser->id == Auth::id())
          <a class="" onclick="getFile()" style="cursor:pointer; z-index: 4; position: absolute; right: 5px; top: 5px;">
            <span class="fa fa-edit text-light" style="font-size: 25px;"></span>
          </a>
        @endif

        <img src="{{url($coverpic)}}" alt="" style="object-fit: cover; height: 250px; width: 100%; border-radius: 0px 0px 0px 10px;">
        <script type="text/javascript">
          function getFile(){
            document.getElementById("upload").click();
          }
        </script>
        {!! Form::open(['action' => 'MediaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
          {{Form::hidden('relation', 'coverpic', [])}}
          {{Form::hidden('user_id', Auth::user()->id, [])}}
          {{Form::hidden('media_type', 'photo', [])}}
          {{Form::file('url', ['id' => 'upload', 'style' => 'display:none;', 'onchange' => 'form.submit()'])}}
        {!! Form::close() !!}
      </div>

      <!-- Change Profile pic-->
      <div class="propic row" style="z-index: 3; left: 10px; bottom: -50px; position: absolute; float:left;">
        <div class="col-5">
          <?php
            if($prouser->profile_pic){
              $med = App\Media::find($prouser->profile_pic);
              $img = '/storage/images/'.$med->url;
            }
            else {
              if($prouser->gender === 'male'){
                $img = 'images/male.png';

              }
              else{
                $img = 'images/female.png';
              }
            }
          ?>
          <script type="text/javascript">
            function proPic(){
              document.getElementById("pro").click();
            }
          </script>
          @if($prouser->id == Auth::id())
            <img src="{{url($img)}}" alt="" onclick="proPic()" style="border: solid 2px #fff; width: 130px; height: 130px; cursor:pointer;" class="rounded-circle">
          @else
            <img src="{{url($img)}}" alt="" style="border: solid 2px #fff; width: 130px; height: 130px; cursor: context-menu;" class="rounded-circle">
          @endif
          {!! Form::open(['action' => 'MediaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {{Form::hidden('redirect', 'profile', [])}}
            {{Form::hidden('relation', 'propic', [])}}
            {{Form::hidden('user_id', Auth::user()->id, [])}}
            {{Form::hidden('media_type', 'photo', [])}}
            {{Form::file('url', ['id' => 'pro', 'style' => 'display:none;', 'onchange' => 'form.submit()'])}}
          {!! Form::close() !!}
        </div>
      </div>
      <div class="" style="z-index: 3; left: 150px; bottom: 0px; position: absolute; float:left;">
        <a href="/profile/{{$prouser->id}}/{{$prouser->last_name}}" class="link text-light">
          <h4 class="font-weight-bold text-center text-capitalize">{{$prouser->first_name.' '.$prouser->last_name}}</h4>
        </a>
      </div>
    </div>
    <div class="offset-1 col-11 card" style="top: -50px;">
      <div class="row m-0">
        <div class="offset-1 col-8 row">
          <a class="nav-link font-weight-bold link col-2" href="/profile/{{$prouser->id}}/{{$prouser->last_name}}">Timeline</a>
          <a class="nav-link font-weight-bold link col-2" href="/about/{{$prouser->id}}/{{$prouser->last_name}}">About</a>
          <a class="nav-link font-weight-bold link col-2" href="/friends/{{$prouser->id}}/{{$prouser->last_name}}">Friends</a>
          <a class="nav-link font-weight-bold link col-2" href="/photos/{{$prouser->id}}/{{$prouser->last_name}}">Photos</a>
        </div>
        @if(!$alreadyfnd)
          <div class="col-3">
            <script type="text/javascript">
              function addfriend(){
                document.add.submit();
              }
            </script>
            <!-- Add Friend button-->
            {!! Form::open(['action' => 'FriendsController@store', 'method' => 'POST', 'name' => 'add']) !!}
              {{Form::hidden('from_user_id', Auth::user()->id, [])}}
              {{Form::hidden('to_user_id', $prouser->id, [])}}
              {{Form::hidden('status', 'pending', [])}}
            {!! Form::close() !!}

            <a class="nav-link font-weight-bold link float-right text-right" style="cursor: pointer;" href="javascript: addfriend()">
              <span class="fa fa-user-plus text-right" style="font-size:25px;"></span>
            </a>
          </div>
        @endif
      </div>
    </div>
    <div class="row m-1">
      <div class="col-3 card text-left p-1">
        <h4><span class="fa fa-globe text-dark pr-2"></span>Intro</h4>
      </div>
      @if($page === 'profile')
        @include('inc.timeline')
      @elseif($page === 'about')
        @include('inc.about')
      @elseif($page === 'friends')
        @include('inc.friendlist')
      @elseif($page === 'photos')
        @include('inc.photos')
      @else
        <p>Nothing to Show</p>
      @endif
    </div>
  </div>
  @include('inc.rightsidebar')
@endsection
