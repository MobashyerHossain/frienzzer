<ul class="list-group">
  <?php
    $requests = App\Friend::where('to_id', '=', Auth::id())->where('status', '=', 'pending')->get();
  ?>

  @if(count($requests) > 0)
    @foreach($requests as $request)
      <a href="/profile/{{$request->id}}/{{$request->last_name}}" class="link">
        <li class="list-group-item border-0 m-0 p-1">
          <div class="row">
            <div class="col-1">
              <?php
                $requesteduser = App\User::find($request->from_id);
                $promed = App\Media::find($requesteduser->profile_pic);
                if($requesteduser->profile_pic){
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
              <a href="/profile/{{$requesteduser->id}}/{{$requesteduser->last_name}}" class="link text-primary">
                <img src="{{url($proimg)}}" alt="" style="width: 25px; height: 25px;" class="rounded-circle">
              </a>
            </div>
            <div class="col-5 mt-1">
              <a href="/profile/{{$requesteduser->id}}/{{$requesteduser->last_name}}" class="link text-primary">
                <h6 class="font-weight-bold text-dark text-capitalize">{{$requesteduser->first_name.' '.$requesteduser->last_name}}</h6>
              </a>
            </div>

            <!-- Add friend Button -->
            <div class="col-2">
              {!! Form::open(['action' => ['FriendsController@update', $request], 'method' => 'POST']) !!}
                {{Form::hidden('_method','put')}}
                {{Form::hidden('status', 'accepted', [])}}
                {{Form::submit('Accept',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
              {!! Form::close() !!}
            </div>

            <!-- Block friend Button -->
            <div class="col-3">
              {!! Form::open(['action' => ['FriendsController@update', $request], 'method' => 'POST']) !!}
                {{Form::hidden('_method','put')}}
                {{Form::hidden('status', 'blocked', [])}}
                {{Form::submit('Block',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
              {!! Form::close() !!}
            </div>
          </div>
        </li>
      </a>
    @endforeach
  @else
    <li class="text-center list-group-item">
      No Request Pending
    </li>
  @endif
</ul>
