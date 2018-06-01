<div class="card mb-4 p-3 pr-md-5 pl-md-5 pt-md-4 col-12">
  <div class="body text-left mb-2">
    <div class="row">
      <?php
        // Get Posts
        $postuser = App\User::find($post->user_id);
        $username = $postuser->first_name.' '.$postuser->last_name;
        if($postuser->profile_pic){
          $med = App\Media::find($postuser->profile_pic);
          $userpropic = '/storage/images/'.$med->url;
        }
        else {
          if($postuser->gender === 'male'){
            $userpropic = 'images/male.png';
          }
          else{
            $userpropic = 'images/female.png';
          }
        }
        $comment_date = '   '.$post->created_at;

        // Get Comments
        $postcommentlink = App\Comment::where('post_id', $post->id)->pluck('comment_id');
        $comments = App\Post::whereIn('id', $postcommentlink)->orderBy('created_at', 'desc')->get();
        if (count($comments) > 99) {
          $commentcount = '99+';
        }
        else {
          $commentcount = count($comments);
        }
      ?>

      <div class="col-lg-1">
        <a href="/profile/{{$postuser->id}}/{{$postuser->last_name}}" class="link">
          <img src="{{url($userpropic)}}" alt="" class="float-right rounded-circle img-responsive d-none d-lg-block" style="width: 50px; height: 50px;">
        </a>
      </div>
      <div class="col-lg-11 mb-2">
        <a href="/profile/{{$postuser->id}}/{{$postuser->last_name}}" class="link">
          <h4 class="m-0" style="color:#007fff;">{{$username}}</h4>
        </a>
        <a href="/posts/{{$post->id}}" class="text-dark m-0 pl-1">
          @if($post->created_at != $post->updated_at)
            <small style="font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100;">
              <span class="font-weight-bold">Edited</span>
            </small>
          @endif
          <small style="font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100;">
            Posted on <span>{{$post->created_at}}</span>
          </small>
        </a>
      </div>
      <div id="postdiv.{{$post->id}}.edit" class="col-11 offset-1">
        <div id="collapse.{{$post->id}}.edit" class="collapse show" aria-labelledby="heading.{{$post->id}}.edit" data-parent="#accordion">
          <div id="postText.{{$post->id}}.edit">
            <p class="text-dark font-weight-normal p-1 rounded mb-0 h5">{{$post->body_text}}</p>
          </div>
        </div>
      </div>

      <!--Edit Post-->
      <div class="col-12 mr-0 ml-0">
        <div id="collapse.{{$post->id}}.edit" class="collapse hide" aria-labelledby="heading.{{$post->id}}.edit" data-parent="#accordion">
          {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST']) !!}
            <div class="form-group row mb-0">
              <div class="col-md-11 col-12 offset-md-1">
                {{Form::hidden('_method','put')}}
                {{Form::textarea('body', $post->body_text, ['style' => 'outline: none; box-shadow:none !important; max-height: 60px; overflow:hidden; resize: none; font-size: 13px; background-color:#fff;', 'class' => 'col-12 form-control'])}}
              </div>
              <div class="col-md-11 col-12 offset-md-1 mt-1">
                {{Form::submit('Update',['class' => 'btn btn-primary float-right'])}}
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>

      <!--Media-->
      <?php
        $mediaID = App\Post_Media::where('post_id', '=', $post->id)->pluck('media_id');
        $banners = App\Media::whereIn('id', $mediaID)->get();
      ?>
      @if(count($banners) > 0)
        <div class="col-md-10 offset-md-1" style="max-height: 230px; overflow: auto;">
          @foreach($banners as $banner)
            <?php
              $tem = '/storage/images/'.$banner->url;
            ?>
            <a data-toggle="modal" data-target="#mediaModal{{$banner->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
              <img src="{{$tem}}" alt="" style="width: 30%; height: 100px; float: left; margin: 5px; object-fit:cover">
            </a>

            <!-- Media Modal -->
            <div class="modal fade bd-example-modal-lg" id="mediaModal{{$banner->id}}" tabindex="-1" aria-labelledby="mediaModalTitle{{$banner->id}}" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header bg-dark p-1">
                    <h5 class="modal-title text-light" id="mediaModalTitle{{$banner->id}}">{{$postuser->first_name.' '.$postuser->last_name}}</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body bg-dark p-1">
                    <img src="{{$tem}}" alt="" style="width: 100%;" class="p-2">
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
      </div>
  </div>

  <div class="row">
    <div class="col-10">
      <div class="row">

        <!-- Likes -->
        <?php
          $likes = App\Like::where('post_id', $post->id)->orderBy('created_at')->get();
          $mylike = App\Like::where('user_id', Auth::id())->where('post_id', $post->id)->get();

          if (count($likes) > 99) {
            $likescount = '99+';
          }
          else {
            $likescount = count($likes);
          }
        ?>
        <div class="col-1">
        </div>

        <div class="col-2 row">
          <a data-toggle="modal" data-target="#LikeModal{{$post->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
            <span style="padding: 3px; font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100; background-color: #cfd2d6;" class="mr-1 rounded font-weight-normal">
              {{$likescount}}
            </span>
          </a>
          @if(count($mylike) > 0)
            <!-- Unlike -->
            {!!Form::open(['action' => ['LikesController@destroy', $post->id], 'method' => 'POST'])!!}
              {{Form::hidden('user', Auth::id(), [])}}
              {{Form::hidden('_method', 'DELETE')}}
              {{Form::button('<i class="fa fa-heart text-danger mt-2" style="font-size: 20px;"></i>', ['type' => 'submit', 'style' => 'background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;'])}}
            {!!Form::close()!!}

          @else
            <!-- Like -->
            {!! Form::open(['action' => 'LikesController@store', 'method' => 'POST']) !!}
              {{Form::hidden('post', $post->id, [])}}
              {{Form::hidden('user', Auth::user()->id, [])}}
              {{Form::button('<i class="fa fa-heart-o text-danger mt-2" style="font-size: 20px;"></i>', ['type' => 'submit', 'style' => 'background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;'])}}
            {!! Form::close() !!}
          @endif

          <!-- Like Modal -->
          <div class="modal fade" id="LikeModal{{$post->id}}" tabindex="-1"aria-labelledby="LikeModalTitle{{$post->id}}" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="LikeModalTitle{{$post->id}}">Likes</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="max-height:300px; overflow: auto; overflow-y: scroll;">
                  @foreach($likes as $like)
                    <?php
                      $liker = App\User::find($like->user_id);
                    ?>
                    <a href="/profile/{{$liker->id}}/{{$liker->last_name}}" class="link">
                      <li class="list-group-item border-0 m-0 p-1">
                        <div class="row">
                          <div class="col-1">
                            <?php
                              $promed = App\Media::find($liker->profile_pic);
                              if($liker->profile_pic){
                                $proimg = '/storage/images/'.$promed->url;
                              }
                              else{
                                if($liker->gender === 'male'){
                                  $proimg = '/images/male.png';
                                }
                                else{
                                  $proimg = '/images/female.png';
                                }
                              }
                             ?>
                            <img src="{{url($proimg)}}" alt="" style="width: 25px; height: 25px;" class="rounded-circle">
                          </div>
                          <div class="col-5 mt-1">
                            <h6 class=" text-left font-weight-bold text-dark text-capitalize">{{$liker->first_name.' '.$liker->last_name}}</h6>
                          </div>
                        </div>
                      </li>
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Comments -->
        <div class="col-4">
          <a href="" class="dropdown-toggle font-weight-bold text-dark link nav-link" data-toggle="collapse" data-target="#collapse.{{$post->id}}" aria-expanded="true" aria-controls="collapse.{{$post->id}}">
            <span style="padding: 2px; font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100; background-color: #cfd2d6;" class="mt-0 p-1 mr-1 rounded font-weight-normal">
              {{$commentcount}}
            </span> Comments
          </a>
        </div>
      </div>
    </div>
    <div class="options col-2">
      <ul class="navbar-nav">
        <li class="nav-item dropdown ml-auto">
            <a id="navbarDropdown" class="font-weight-bold text-dark link nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <span class="caret">Options</span>
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="/posts/{{$post->id}}">
                    {{ __('View Details') }}
                </a>
                @if($post->user_id !== Auth::id())
                  <a href="" class="dropdown-item" data-toggle="collapse" data-target="#collapse.{{$post->id}}.edit" aria-expanded="true" aria-controls="collapse.{{$post->id}}.edit">
                      {{ __('Edit') }}
                  </a>
                  {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                      {{Form::hidden('_method', 'DELETE')}}
                      {{Form::submit('Delete', ['class' => 'btn btn-link text-dark link dropdown-item'])}}
                  {!!Form::close()!!}
                @endif
            </div>
        </li>
      </ul>
    </div>

    <!--Comment on Post-->
    <div class="card-body col-12">
      {!! Form::open(['action' => 'CommentsController@store', 'method' => 'POST']) !!}
        <div class="form-group row mb-0">
          <div class="col-lg-10 col-12">
            {{Form::hidden('user_id', Auth::user()->id, [])}}
            {{Form::hidden('type', 'comment', [])}}
            {{Form::hidden('post_id', $post->id, [])}}
            {{Form::text('body', '', ['style' => 'outline: none; resize: none; box-shadow:none !important; font-size: 13px; background-color:#fff;', 'class' => 'col-12 form-control', 'placeholder' => 'Share your comment...'])}}
          </div>
          <div class="col-lg-2 col-12 mt-lg-0 mt-3">
            {{Form::submit('Comment',['class' => 'btn btn-primary float-right'])}}
          </div>
        </div>
      {!! Form::close() !!}
    </div>

    <!-- Show Comments-->
    <div class="col-12 m-0 p-0 rounded mb-0">
      @if($commentcount > 5)
        <div id="collapse.{{$post->id}}" class="collapse" aria-labelledby="heading.{{$post->id}}" data-parent="#accordion">
          @include('inc.showcomments')
        </div>
      @else
        <div id="collapse.{{$post->id}}" aria-labelledby="heading.{{$post->id}}" data-parent="#accordion">
          @include('inc.showcomments')
        </div>
      @endif
    </div>
  </div>
</div>
