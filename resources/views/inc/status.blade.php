<div class="card-header text-left pt-0">
    <ul class="nav nav-tabs card-header-tabs font-weight-bold">
      <li class="nav-item">
        <a class="nav-link text-dark" style="cursor:pointer;">Make Posts</a>
      </li>
      <li class="nav-item">
        <script type="text/javascript">
          function getFile(){
            document.getElementById("upload").click();
          }
        </script>
        <a class="nav-link text-dark" onclick="getFile()" style="cursor:pointer;">Share Photos</a>
        {!! Form::open(['action' => 'MediaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
          {{Form::hidden('relation', 'temp', [])}}
          {{Form::hidden('user_id', Auth::user()->id, [])}}
          {{Form::hidden('media_type', 'photo', [])}}
          {{Form::file('url', ['id' => 'upload', 'style' => 'display:none;', 'onchange' => 'form.submit()'])}}
        {!! Form::close() !!}
      </li>
    </ul>
  </div>
  <div class="card-body row">
    <div class="col-lg-1">
      <?php
        if(Auth::user()->profile_pic){
          $med = App\Media::find(Auth::user()->profile_pic);
          $img = '/storage/images/'.$med->url;
          $noPro = false;
        }
        else {
          $noPro = true;
          if(Auth::user()->gender === 'male'){
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
      @if($noPro)
        <img src="{{url($img)}}" alt="" onclick="proPic()" style="width: 80px; height: 80px; cursor:pointer;" class="ml-4 mr-4 rounded-circle d-none d-lg-block">
      @else
        <a href="/profile/{{Auth::id()}}/{{Auth::user()->last_name}}">
          <img src="{{url($img)}}" alt=""  style="width: 80px; height: 80px; cursor:pointer;" class="ml-4 mr-4 rounded-circle d-none d-lg-block">
        </a>
      @endif
      {!! Form::open(['action' => 'MediaController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {{Form::hidden('relation', 'propic', [])}}
        {{Form::hidden('user_id', Auth::user()->id, [])}}
        {{Form::hidden('media_type', 'photo', [])}}
        {{Form::file('url', ['id' => 'pro', 'style' => 'display:none;', 'onchange' => 'form.submit()'])}}
      {!! Form::close() !!}
    </div>
    <script type="text/javascript">
      function submitstatus(){
        document.statuspost.submit();
      }
    </script>
    <div class="col-lg-10 pl-lg-4 offset-lg-1 col-12">
      {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'name' => 'statuspost']) !!}
        <div class="form-horizontal">
          {{Form::hidden('user_id', Auth::user()->id, [])}}
          {{Form::hidden('type', 'post', [])}}
          {{Form::textarea('body', '', ['style' => 'height:80px; font-size: 20px; outline: none; resize: none; box-shadow:none !important; overflow:hidden; border:none;', 'class' => 'form-control', 'placeholder' => 'Whats on your mind....'])}}
        </div>
      {!! Form::close() !!}
    </div>

    <!-- Temp Uploads -->
    <?php
      use Carbon\Carbon;
      $current = Carbon::now();
      $limit = $current->subMinutes(1);
      $uselessmedia = App\Media::where('user_id', '=', Auth::id())->where('relation','=', 'temp')->where('created_at', '<', $limit)->get();
      foreach ($uselessmedia as $useless) {
        $useless->delete();
      }
      $tempmedia = App\Media::where('user_id', '=', Auth::id())->where('relation','=', 'temp')->get();
    ?>
    @if(count($tempmedia) > 0)
      <div class="col-md-9 offset-md-2 col-11">
        @foreach($tempmedia as $temp)
          <?php
            $tem = '/storage/images/'.$temp->url;
          ?>
          <img src="{{$tem}}" alt="" style="width: 40px; height:40px; float: left; margin: 5px;">
        @endforeach
        <a onclick="getFile()" style="cursor:pointer;">
          <span class="fa fa-plus font-weight-normal text-dark" style="opacity: .5; padding-top: 2px; padding-right: 1px; background-color: gray; font-size: 40px; width: 40px; height:40px; float: left; margin: 5px;"></span>
        </a>
      </div>
    @else
      <div class="col-md-9 offset-md-2 col-11">
      </div>
    @endif
    <div class="col-1 mt-3">
      <a class="float-right" style="cursor: pointer;" href="javascript: submitstatus()">
        <span class="fa fa-arrow-circle-right" style="font-size:25px;"></span>
      </a>
    </div>
  </div>
  <div class="card-footer p-1 row m-0">
    <div class="offset-2 col-10 mt-1">
      <ul class="nav card-footer-tab">
        <li class="nav-item mr-4">
          <a class="nav-link text-dark m-0 p-0" onclick="getFile()" style="cursor:pointer;">
            <span class="fa fa-camera" style="font-size: 20px;"></span>
          </a>
        </li>
        <li class="nav-item mr-4">
          <a data-toggle="modal" data-target="#tagModal" class="m-0 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
            <span class="fa fa-tag" style="font-size: 20px;">Tag</span>
          </a>

          <?php
            $f1 = App\Friend::where('from_id', '=', Auth::id())->where('status', '=', 'accepted')->pluck('to_id');
            $f2 = App\Friend::where('to_id', '=', Auth::id())->where('status', '=', 'accepted')->pluck('from_id');
            $frds = App\User::whereIn('id', $f1)->orWhereIn('id', $f2)->orderBy('first_name', 'asc')->get();
          ?>
          <!-- Like Modal -->
          <div class="modal fade" id="tagModal" tabindex="-1"aria-labelledby="tagModalTitle" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header p-1">
                  <h5 class="modal-title pl-2" id="tagModalTitle">Tag</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background-color: transparent; border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important; border:none;">
                    <span aria-hidden="true" class="fa fa-close p-1"></span>
                  </button>
                </div>
                <div class="modal-body p-0" style="max-height: 400px; overflow:auto; overflow-x:hidden;">
                  <table class="table table-hover">
                    <tr>
                      <p class="text-center">Warning this tag will last for only 1 minute!</p>
                    </tr>
                    @foreach($frds as $frd)
                      <?php
                        $profrd = App\Media::find($frd->profile_pic);
                        if($frd->profile_pic){
                          $proimg = '/storage/images/'.$profrd->url;
                        }
                        else{
                          if($frd->gender === 'male'){
                            $proimg = '/images/male.png';
                          }
                          else{
                            $proimg = '/images/female.png';
                          }
                        }
                       ?>
                      <tr class="m-0 p-0 text-left">
                        <td class="float-left col-1">
                          <img src="{{url($proimg)}}" alt="" style="width: 20px; height: 20px;" class="rounded-circle m-0 p-0">
                        </td>
                        <td class="float-left col-10">
                          <h6 class="mt-1">{{$frd->first_name.' '.$frd->last_name}}</h6>
                        </td>
                        <td class="float-right col-1">
                          <input type="checkbox" name="friends[]" value="{{$frd->id}}">
                        </td>
                      </tr>
                    @endforeach
                  </table>
                </div>
                <div class="modal-footer">
                  <input type="submit" name="submit" value="submit">
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
