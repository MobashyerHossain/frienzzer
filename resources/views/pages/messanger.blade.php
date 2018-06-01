@extends('layouts.app')

@section('content')
  <script type="text/javascript">
    function updateScroll(){
      var element = document.getElementById("scrollmes");
      element.scrollTop = element.scrollHeight;
    }

    window.onload = updateScroll;
  </script>
  <div class="col-md-2 sidenav position-sticky p-2 d-none d-md-block" style="background-color:transparent;">
    <div class="card" style="width:200px; height:85vh; position:fixed;">
      <div class="card-header text-left p-1 font-weight-bold">
        Messages
      </div>
      @include('inc.messagebar')
    </div>
  </div>

  <!-- Message area-->
  <div class="col-lg-8 col-md-10 mt-3">
    <!-- Identify Profile-->
    <?php
      $url = $_SERVER['REQUEST_URI'];
      $trimurl = explode('/',$url);
      $id_1 = $trimurl[2];
      $id_2 = $trimurl[3];
      if($id_1 === $id_2){
        $same = true;
      }
      else{
        $same = false;
      }
      $me = App\User::find($id_1);
      $other = App\User::find($id_2);
      $messages1 = App\Message::where('from_id', '=', $me->id)->where('to_id', '=', $other->id)->orderBy('created_at', 'asc')->pluck('id');
      $messages2 = App\Message::where('from_id', '=', $other->id)->where('to_id', '=', $me->id)->orderBy('created_at', 'asc')->pluck('id');
      $mess = $messages1->merge($messages2);
      $messages = App\Message::whereIn('id', $mess)->orderBy('created_at', 'asc')->get();
    ?>
    <div class="card" style="position:fixed; width:64%;">
      <div class="card-header col-12 m-0 p-1 text-left pl-2">
        @if($same)
          <h5>Messanger</h5>
        @else
          <a href="/profile/{{$other->id}}/{{$other->last_name}}" class="text-dark">
            <h5>{{$other->first_name.' '.$other->last_name}}</h5>
          </a>
        @endif
      </div>
      <div id="scrollmes" class="card-body" style="overflow: auto; height:70vh;">
        @if(count($messages) > 0)
          @foreach($messages as $message)
            <?php
              $mespost = App\Post::find($message->post_id);
              $mediaID = App\Post_Media::where('post_id', '=', $mespost->id)->pluck('media_id');
              $banners = App\Media::whereIn('id', $mediaID)->get();
              $mesuser = App\User::find($mespost->user_id);

              //get propic
              if($mesuser->profile_pic){
                $med = App\Media::find($mesuser->profile_pic);
                $img = '/storage/images/'.$med->url;
              }
              else {
                if($mesuser->gender === 'male'){
                  $img = 'images/male.png';

                }
                else{
                  $img = 'images/female.png';
                }
              }
            ?>
            @if(Auth::id() == $mespost->user_id)
              <div class="mr-auto text-left col-md-7 col-10 p-2 mb-2" style="background: rgba(173, 173, 173, 0.5); border-radius: 5px; overflow: auto; overflow-x:hidden;">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-1">
                        <a href="/profile/{{$mesuser->id}}/{{$mesuser->last_name}}" class="link">
                          <img src="{{url($img)}}" alt="" class="float-left rounded-circle img-responsive" style="width: 20px; height: 20px;">
                        </a>
                      </div>
                      <div class="col-11">
                        <a href="/profile/{{$mesuser->id}}/{{$mesuser->last_name}}" class="link">
                          <h6 class="m-0 font-weight-bold" style="color:#000000;">{{$mesuser->first_name.' '.$mesuser->last_name}}</h6>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <p>{{$mespost->body_text}}</p>
                  </div>
                  <div class="col-12">
                    @if(count($banners) > 0)
                      @foreach($banners as $banner)
                        <?php
                          $tem = '/storage/images/'.$banner->url;
                        ?>
                        <a data-toggle="modal" data-target="#mediaModal{{$banner->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
                          <img src="{{$tem}}" alt="" style="width: 100%;" class="p-2">
                        </a>

                        <!-- Media Modal -->
                        <div class="modal fade bd-example-modal-lg" id="mediaModal{{$banner->id}}" tabindex="-1" aria-labelledby="mediaModalTitle{{$banner->id}}" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5); z-index: 3 !important; top: 40px;">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header bg-dark p-1">
                                <h5 class="modal-title text-light" id="mediaModalTitle{{$banner->id}}">{{$mesuser->first_name.' '.$mesuser->last_name}}</h5>
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
                    @endif
                  </div>
                  <div class="text-left col-6">
                    <small style="font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100; color: #757575;">
                      Posted on <span>{{$mespost->created_at}}</span>
                    </small>
                  </div>
                  <div class="text-right col-6">
                    <?php
                      $mylike = App\Like::where('user_id', Auth::id())->where('post_id', $mespost->id)->get();
                    ?>
                    @if(count($mylike) > 0)
                      <!-- Unlike -->
                      {!! Form::open(['action' => ['LikesController@destroy', $mespost->id], 'method' => 'POST']) !!}
                        {{Form::hidden('user', Auth::id(), [])}}
                        {{Form::hidden('dst', 'message', [])}}
                        {{Form::hidden('to_id', $other->id, [])}}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::button('<i class="fa fa-heart text-danger" style="font-size: 20px;"></i>', ['type' => 'submit', 'style' => 'background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;'])}}
                      {!!Form::close()!!}
                    @else
                      <!-- Like -->
                      {!! Form::open(['action' => 'LikesController@store', 'method' => 'POST']) !!}
                        {{Form::hidden('post', $mespost->id, [])}}
                        {{Form::hidden('user', Auth::id(), [])}}
                        {{Form::hidden('dst', 'message', [])}}
                        {{Form::hidden('to_id', $other->id, [])}}
                        {{Form::button('<i class="fa fa-heart-o text-danger" style="font-size: 20px;"></i>', ['type' => 'submit', 'style' => 'background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;'])}}
                      {!! Form::close() !!}
                    @endif
                  </div>
                </div>
              </div>
            @else
              <div class="ml-auto text-left col-md-7 col-10 p-2 mb-2" style="background: rgba(7, 255, 0, 0.5); border-radius: 5px; overflow: auto; overflow-x:hidden;">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-11">
                        <a href="/profile/{{$mesuser->id}}/{{$mesuser->last_name}}" class="link text-right">
                          <h6 class="m-0 font-weight-bold" style="color:#000000;">{{$mesuser->first_name.' '.$mesuser->last_name}}</h6>
                        </a>
                      </div>
                      <div class="col-1">
                        <a href="/profile/{{$mesuser->id}}/{{$mesuser->last_name}}" class="link">
                          <img src="{{url($img)}}" alt="" class="float-right rounded-circle img-responsive" style="width: 20px; height: 20px;">
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 text-right">
                    <p>{{$mespost->body_text}}</p>
                  </div>
                  <div class="col-12">
                    @if(count($banners) > 0)
                      @foreach($banners as $banner)
                        <?php
                          $tem = '/storage/images/'.$banner->url;
                        ?>
                        <a data-toggle="modal" data-target="#mediaModal{{$banner->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
                          <img src="{{$tem}}" alt="" style="width: 100%;" class="p-2">
                        </a>

                        <!-- Media Modal -->
                        <div class="modal fade bd-example-modal-lg" id="mediaModal{{$banner->id}}" tabindex="-1" aria-labelledby="mediaModalTitle{{$banner->id}}" aria-hidden="true" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5); z-index: 3 !important; top: 40px;">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header bg-dark p-1">
                                <h5 class="modal-title text-light" id="mediaModalTitle{{$banner->id}}">{{$mesuser->first_name.' '.$mesuser->last_name}}</h5>
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
                    @endif
                  </div>
                  <div class="text-left col-6">
                    <?php
                      $mylike = App\Like::where('user_id', Auth::id())->where('post_id', $mespost->id)->get();
                    ?>
                    @if(count($mylike) > 0)
                      <!-- Unlike -->
                      {!! Form::open(['action' => ['LikesController@destroy', $mespost->id], 'method' => 'POST']) !!}
                        {{Form::hidden('user', Auth::id(), [])}}
                        {{Form::hidden('dst', 'message', [])}}
                        {{Form::hidden('to_id', $other->id, [])}}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::button('<i class="fa fa-heart text-danger" style="font-size: 20px;"></i>', ['type' => 'submit', 'style' => 'background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;'])}}
                      {!!Form::close()!!}
                    @else
                      <!-- Like -->
                      {!! Form::open(['action' => 'LikesController@store', 'method' => 'POST']) !!}
                        {{Form::hidden('post', $mespost->id, [])}}
                        {{Form::hidden('user', Auth::id(), [])}}
                        {{Form::hidden('dst', 'message', [])}}
                        {{Form::hidden('to_id', $other->id, [])}}
                        {{Form::button('<i class="fa fa-heart-o text-danger" style="font-size: 20px;"></i>', ['type' => 'submit', 'style' => 'background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;'])}}
                      {!! Form::close() !!}
                    @endif
                  </div>
                  <div class="text-right col-6">
                    <small style="font-family: brandon-grotesque, sans-serif; font-style:normal; font-weight: 100; color: #757575;">
                      Posted on <span>{{$mespost->created_at}}</span>
                    </small>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        @else
          @if($same)
            <br><br><br>
            <h4>Welcome To Frienzzer Messanger</h4>
            <p class="text-center font-weight-normal">Please, Select any Message Tab from your Left Sidebar</p>
          @else
            <p class="text-center font-weight-bold">No Messages</p>
          @endif
        @endif
      </div>
      @if(!$same)
        <div class="row card-footer p-0">
          <div class="col-1">
            <script type="text/javascript">
              function getFile(){
                document.getElementById("upload").click();
              }
            </script>
            <a class="nav-link text-dark" onclick="getFile()" style="cursor:pointer;">
              <span class="fa fa-photo"></span>
            </a>
            {!! Form::open(['action' => 'MediaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
              {{Form::hidden('relation', 'temp', [])}}
              {{Form::hidden('dst', 'message', [])}}
              {{Form::hidden('user_id', Auth::user()->id, [])}}
              {{Form::hidden('to_id', $other->id, [])}}
              {{Form::hidden('media_type', 'photo', [])}}
              {{Form::file('url', ['id' => 'upload', 'style' => 'display:none;', 'onchange' => 'form.submit()'])}}
            {!! Form::close() !!}
          </div>
          <div class="col-11">
            <script type="text/javascript">
              function submitform(){
                document.mes.submit();
              }
            </script>
            {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'name' => 'mes']) !!}
                <div class="form-inline">
                  {{Form::hidden('user_id', Auth::user()->id, [])}}
                  {{Form::hidden('to_id', $other->id, [])}}
                  {{Form::hidden('type', 'message', [])}}
                  {{Form::text('body', '', ['style' => 'width: 95%; outline: none; resize: none; box-shadow:none !important; overflow:hidden; border:none;', 'class' => 'mt-1 form-control', 'placeholder' => 'Whats on your mind....'])}}
                  <a style="cursor: pointer;" href="javascript: submitform()">
                    <span class="fa fa-arrow-circle-right" style="font-size:25px;"></span>
                  </a>
                </div>
            {!! Form::close() !!}
          </div>
        </div>
      @endif
    </div>
  </div>
  @include('inc.rightsidebar')
@endsection
