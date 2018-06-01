<div class="comment offset-md-1 col-lg-11">

  @foreach($comments as $comment)
  <div class="body text-left mb-4">
    <div class="row">
      <?php
        $commentuser = App\User::find($comment->user_id);
        $com_username = $commentuser->first_name.' '.$commentuser->last_name;
        if($commentuser->profile_pic){
          $med = App\Media::find($commentuser->profile_pic);
          $com_userpropic = '/storage/images/'.$med->url;
        }
        else {
          if($commentuser->gender === 'male'){
            $com_userpropic = 'images/male.png';
          }
          else{
            $com_userpropic = 'images/female.png';
          }
        }
        $comment_date = '   '.$comment->created_at;
      ?>
      <div class="col-lg-1">
        <a href="/profile/{{$commentuser->id}}/{{$commentuser->last_name}}" class="link">
          <img src="{{url($com_userpropic)}}" alt="" class="float-right rounded-circle img-responsive d-none d-lg-block" style="width: 30px; height: 30px;">
        </a>
      </div>
      <div class="col-lg-10 col-11">
        <a href="/profile/{{$commentuser->id}}/{{$commentuser->last_name}}" class="link">
          <h6 class="mb-0 ml-0" style="color:#007fff;">{{$com_username}}</h6>
        </a>
        <small style="font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100;">
          Posted on<span>{{$comment_date}}</span>
        </small>
        @if($comment->created_at != $comment->updated_at)
          <small style="font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100;">
            <span class="font-weight-bold">(Edited)</span>
          </small>
        @endif
      </div>
      <div class="col-lg-1 col-1">
        <a id="navbarDropdown" class="font-weight-bold text-dark link nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <span class="caret fa fa-gear p-2 link" style="color: #a3a3a3; font-size:15px;"></span>
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @if($comment->user_id !== Auth::id())
              <a href="" class="dropdown-item" data-toggle="collapse" data-target="#collapse.{{$comment->id}}.edit" aria-expanded="true" aria-controls="collapse.{{$comment->id}}.edit">
                  {{ __('Edit') }}
              </a>
              {!!Form::open(['action' => ['PostsController@destroy', $comment->id], 'method' => 'POST'])!!}
                  {{Form::hidden('_method', 'DELETE')}}
                  {{Form::submit('Delete', ['class' => 'btn btn-link text-dark link dropdown-item'])}}
              {!!Form::close()!!}
            @endif
        </div>
      </div>
      <div id="postdiv.{{$comment->id}}.edit" class="col-11 offset-1">
        <div id="collapse.{{$comment->id}}.edit" class="collapse show" aria-labelledby="heading.{{$comment->id}}.edit" data-parent="#accordion">
          <div id="postText.{{$comment->id}}.edit">
            <p class="text-dark font-weight-normal bg-light p-1 rounded border mb-0">{{$comment->body_text}}</p>
          </div>
        </div>
      </div>

      <!--Edit Post-->
      <div class="col-12 mr-0 ml-0">
        <div id="collapse.{{$comment->id}}.edit" class="collapse hide" aria-labelledby="heading.{{$comment->id}}.edit" data-parent="#accordion">
          {!! Form::open(['action' => ['PostsController@update', $comment->id], 'method' => 'POST']) !!}
            <div class="form-group row mb-0">
              <div class="col-md-11 col-12 offset-md-1">
                {{Form::hidden('_method','put')}}
                {{Form::textarea('body', $comment->body_text, ['style' => 'outline: none; box-shadow:none !important; max-height: 60px; overflow:hidden; resize: none; font-size: 13px; background-color:#fff;', 'class' => 'col-12 form-control'])}}
              </div>
              <div class="col-md-11 col-12 mt-1 offset-md-1">
                {{Form::submit('Update',['class' => 'btn btn-primary float-right'])}}
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
