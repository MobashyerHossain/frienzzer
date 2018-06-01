<ul class="list-group">
  <?php
    $except1 = App\Friend::where('to_id', '=', Auth::id())->pluck('from_id');
    $except2 = App\Friend::where('from_id', '=', Auth::id())->pluck('to_id');
    $suggesteduser = App\User::where('id', '<>', Auth::id())->whereNotIn('id',$except1)->whereNotIn('id',$except2)->get();
  ?>

  @if(count($suggesteduser) > 0)
    @foreach($suggesteduser as $others)
      <a href="/profile/{{$others->id}}/{{$others->last_name}}" class="link">
        <li class="list-group-item border-0 m-0 p-1">
          <div class="row">
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
              <a href="/profile/{{$others->id}}/{{$others->last_name}}" class="link text-primary">
                <img src="{{url($proimg)}}" alt="" style="width: 25px; height: 25px;" class="rounded-circle">
              </a>
            </div>
            <div class="col-5 mt-1">
              <a href="/profile/{{$others->id}}/{{$others->last_name}}" class="link text-primary">
                <h6 class="font-weight-bold text-dark text-capitalize">{{$others->first_name.' '.$others->last_name}}</h6>
              </a>
            </div>

            <!-- Add friend Button -->
            <div class="col-2">
              {!! Form::open(['action' => 'FriendsController@store', 'method' => 'POST']) !!}
                  {{Form::hidden('from_user_id', Auth::user()->id, [])}}
                  {{Form::hidden('to_user_id', $others->id, [])}}
                  {{Form::hidden('status', 'pending', [])}}
                  {{Form::submit('Add',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
              {!! Form::close() !!}
            </div>

            <!-- Block friend Button -->
            <div class="col-3">
              {!! Form::open(['action' => 'FriendsController@store', 'method' => 'POST']) !!}
                  {{Form::hidden('from_user_id', Auth::user()->id, [])}}
                  {{Form::hidden('to_user_id', $others->id, [])}}
                  {{Form::hidden('status', 'blocked', [])}}
                  {{Form::submit('Remove',['class' => 'btn btn-secondary pt-0 pb-0 pr-1 pl-1'])}}
              {!! Form::close() !!}
            </div>
          </div>
        </li>
      </a>
    @endforeach
  @endif
</ul>
