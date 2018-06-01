@extends('layouts.app')

@section('content')
  @include('inc.sidebar')
  <div class="col-lg-8 col-md-10 mt-3">

    <!-- Friend Requests -->
    <div class="card mb-3">
      <div class="card-header text-left font-weight-bold" style="line-height:3px;">
        Friend Requests
      </div>
      <div class="request-list mr-5 ml-2">
        <?php
          $requests = App\Friend::where('to_id', '=', Auth::id())->where('status', '=', 'pending')->orderBy('created_at', 'desc')->get();
        ?>

        @if(count($requests) > 0)
          @foreach($requests as $request)
          <div class="card-body row ml-2 mr-2 border-bottom p-1" style="line-height:1px;">
            <a href="/profile/{{$request->id}}/{{$request->last_name}}" class="link w-100">
              <div class="row p-1">
                <div class="col-1">
                  <?php
                    $requesteduser = App\User::find($request->from_id);
                    $promed = App\Media::find($requesteduser->profile_pic);
                    if($requesteduser->profile_pic){
                      $proimg = '/storage/images/'.$promed->url;
                    }
                    else{
                      if($requesteduser->gender === 'male'){
                        $proimg = '/images/male.png';
                      }
                      else{
                        $proimg = '/images/female.png';
                      }
                    }
                   ?>
                  <img src="{{url($proimg)}}" alt="" style="width: 25px; height: 25px;" class="rounded-circle">
                </div>
                <div class="col-8 mt-1">
                  <h6 class="font-weight-bold text-dark text-left text-capitalize">{{$requesteduser->first_name.' '.$requesteduser->last_name}}</h6>
                </div>

                <!-- Add friend Button -->
                <div class="col-1">
                  {!! Form::open(['action' => ['FriendsController@update', $request], 'method' => 'POST']) !!}
                    {{Form::hidden('_method','put')}}
                    {{Form::hidden('status', 'accepted', [])}}
                    {{Form::submit('Accept',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
                  {!! Form::close() !!}
                </div>

                <!-- Block friend Button -->
                <div class="col-1">
                  {!! Form::open(['action' => ['FriendsController@update', $request], 'method' => 'POST']) !!}
                    {{Form::hidden('_method','put')}}
                    {{Form::hidden('status', 'blocked', [])}}
                    {{Form::submit('Block',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
                  {!! Form::close() !!}
                </div>

                <!-- Ignore friend Button -->
                <div class="col-1">
                  {!! Form::open(['action' => ['FriendsController@update', $request], 'method' => 'POST']) !!}
                    {{Form::hidden('_method','put')}}
                    {{Form::hidden('status', 'ignore', [])}}
                    {{Form::submit('Ignore',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
                  {!! Form::close() !!}
                </div>
              </div>
            </a>
          </div>
          @endforeach
        @else
          <div class="justify-content-center m-2">
            No Friend Requests Pending
          </div>
        @endif
      </div>
    </div>

    <!-- Blocked Request List -->
    <div class="card mb-3">
      <div class="card-header text-left font-weight-bold" style="line-height:3px;">
        Blocked List
      </div>
      <div class="blocked-list mr-5 ml-2">
        <?php
          $blocked = App\Friend::Where('from_id', '=', Auth::id())->where('status', '=', 'blocked')->orderBy('created_at', 'desc')->get();
        ?>

        @if(count($blocked) > 0)
          @foreach($blocked as $block)
          <div class="card-body row ml-2 mr-2 border-bottom p-1" style="line-height:1px;">
            <a href="/profile/{{$block->id}}/{{$block->last_name}}" class="link w-100">
              <div class="row p-1">
                <div class="col-1">
                  <?php
                    $blockuser = App\User::find($block->to_id);
                    $promed = App\Media::find($blockuser->profile_pic);
                    if($blockuser->profile_pic){
                      $proimg = '/storage/images/'.$promed->url;
                    }
                    else{
                      if($request->gender === 'male'){
                        $proimg = '/images/male.png';
                      }
                      else{
                        $proimg = '/images/female.png';
                      }
                    }
                   ?>
                  <img src="{{url($proimg)}}" alt="" style="width: 25px; height: 25px;" class="rounded-circle">
                </div>
                <div class="col-10 mt-1">
                  <h6 class="font-weight-bold text-dark text-left text-capitalize">{{$blockuser->first_name.' '.$blockuser->last_name}}</h6>
                </div>

                <!-- Unblock Button -->
                <div class="col-1">
                  {!!Form::open(['action' => ['FriendsController@destroy', $block], 'method' => 'POST'])!!}
                      {{Form::hidden('_method', 'DELETE')}}
                      {{Form::submit('Unblock', ['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
                  {!!Form::close()!!}
                </div>
              </div>
            </a>
          </div>
          @endforeach
        @else
          <div class="justify-content-center m-2">
            No Blocked Requests
          </div>
        @endif
      </div>
    </div>

    <!-- Suggested people -->
    <div class="card mb-3">
      <div class="card-header text-left font-weight-bold" style="line-height:3px;">
        People You May Know
      </div>
      <div class="suggested-list mr-5 ml-2">
        <?php
          $except1 = App\Friend::where('to_id', '=', Auth::id())->pluck('from_id');
          $except2 = App\Friend::where('from_id', '=', Auth::id())->pluck('to_id');
          $suggesteduser = App\User::where('id', '<>', Auth::id())->whereNotIn('id',$except1)->whereNotIn('id',$except2)->orderBy('created_at', 'desc')->get();
        ?>

        @if(count($suggesteduser) > 0)
          @foreach($suggesteduser as $others)
            <div class="card-body row ml-2 mr-2 border-bottom p-1" style="line-height:1px;">
              <a href="/profile/{{$others->id}}/{{$others->last_name}}" class="link w-100">
                <div class="row p-1">
                  <div class="col-1">
                    <?php
                      $promed = App\Media::find($others->profile_pic);
                      if($others->profile_pic){
                        $proimg = '/storage/images/'.$promed->url;
                      }
                      else{
                        if($others->gender === 'male'){
                          $proimg = '/images/male.png';
                        }
                        else{
                          $proimg = '/images/female.png';
                        }
                      }
                     ?>
                    <img src="{{url($proimg)}}" alt="" style="width: 25px; height: 25px;" class="rounded-circle">
                  </div>
                  <div class="col-9 mt-1">
                    <h6 class="font-weight-bold text-dark text-left text-capitalize">{{$others->first_name.' '.$others->last_name}}</h6>
                  </div>

                  <!-- Add friend Button -->
                  <div class="col-1">
                    {!! Form::open(['action' => 'FriendsController@store', 'method' => 'POST']) !!}
                        {{Form::hidden('from_user_id', Auth::user()->id, [])}}
                        {{Form::hidden('to_user_id', $others->id, [])}}
                        {{Form::hidden('status', 'pending', [])}}
                        {{Form::submit('Add',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
                    {!! Form::close() !!}
                  </div>

                  <!-- Block friend Button -->
                  <div class="col-1">
                    {!! Form::open(['action' => 'FriendsController@store', 'method' => 'POST']) !!}
                        {{Form::hidden('from_user_id', Auth::user()->id, [])}}
                        {{Form::hidden('to_user_id', $others->id, [])}}
                        {{Form::hidden('status', 'blocked', [])}}
                        {{Form::submit('Remove',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
                    {!! Form::close() !!}
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
@include('inc.rightsidebar')
@endsection
