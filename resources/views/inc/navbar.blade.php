<nav class="navbar navbar-expand-md navbar-light bg-dark position-sticky fixed-top">
    <div class="container text-light">
      <a class="text-light font-weight-normal h2 pr-md-3 mb-0 link" href="{{ url('/posts') }}">
          {{ config('app.name', 'Frienzzer') }}
      </a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <?php
            $s_users = App\User::orderBy('created_at','desc')->get();
            $s_posts = App\post::where('type', '=', 'post')->orderBy('created_at','desc')->get();
          ?>
          <script>
            $(document).ready(function(){
              $("#sitesearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                if(value != 0){
                  $("#searchlist #slist").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                  });
                  $('#search_box').css('display', 'block');
                }
                else {
                  $('#search_box').css('display', 'none');
                }
              });

              $(document).click(function (e) {
                e.stopPropagation();
                //check if the clicked area is dropDown or not
                if ($('#sitetab').has(e.target).length === 0) {
                  $('#search_box').hide();
                }
              });
            });
          </script>
          <ul class="navbar-nav mr-auto">
            <li id="sitetab" class="nav-item dropdown" style="top: 5px;">
              <input id="sitesearch" type="text" name="" value="" class="pl-2" style="width: 250px; border:none; box-shadow:none !important; outline: none;" placeholder="Search...">

              <div id="search_box" class="dropdown-menu rounded-0"style="width: 350px; overflow: auto; max-height: 400px; display: none;">

                <div id="searchlist" class="card-body p-0 m-0" style="overflow: auto;">
                  <div>
                    <ul class="nav nav-tabs">
                      <li class="nav-item"><a class="nav-link active" role="tab" data-toggle="tab" href="#tab-1">Users</a></li>
                      <li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-2">Posts</a></li>
                      <li class="nav-item"><a class="nav-link" role="tab" data-toggle="tab" href="#tab-3">Photos</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" role="tabpanel" id="tab-1">
                        <!-- Search Users-->
                        <table class="table table-hover" id="tb1">
                          @if(count($s_users) > 0)
                            @foreach($s_users as $s_user)
                              <tr id="slist" class="p-0 m-0">
                                <td class="p-1 m-0" style="width:20px;">
                                  <?php
                                    $promed = App\Media::find($s_user->profile_pic);
                                    if($s_user->profile_pic){
                                      $proimg = '/storage/images/'.$promed->url;
                                    }
                                    else{
                                      if($s_user->gender === 'male'){
                                        $proimg = '/images/male.png';
                                      }
                                      else{
                                        $proimg = '/images/female.png';
                                      }
                                    }
                                   ?>
                                  <a href="/profile/{{$s_user->id}}/{{$s_user->last_name}}" class="link">
                                    <img src="{{url($proimg)}}" alt="" style="width: 20px; height: 20px;" class="rounded-circle m-0 p-0">
                                  </a>
                                </td>
                                <td class="text-left">
                                  <a href="/profile/{{$s_user->id}}/{{$s_user->last_name}}" class="link">
                                    <h6 class="font-weight-bold text-dark text-capitalize" style="font-size: 12px;">{{$s_user->first_name.' '.$s_user->last_name}}</h6>
                                    <p>{{$s_user->email}}</p>
                                  </a>
                                </td>
                              </tr>
                            @endforeach
                          @endif
                          <p id="noUser" class="mt-1 text-center" style="display:none;">No Result Found</p>
                        </table>
                      </div>
                      <div class="tab-pane" role="tabpanel" id="tab-2">
                        <!-- Search Posts-->
                        <table class="table table-hover" id="tb2">
                          @if(count($s_posts) > 0)
                            @foreach($s_posts as $s_post)
                              <tr id="slist">
                                <?php
                                  $poster = App\User::find($s_post->user_id);
                                  $promed = App\Media::find($poster->profile_pic);
                                  if($poster->profile_pic){
                                    $proimg = '/storage/images/'.$promed->url;
                                  }
                                  else{
                                    if($poster->gender === 'male'){
                                      $proimg = '/images/male.png';
                                    }
                                    else{
                                      $proimg = '/images/female.png';
                                    }
                                  }
                                 ?>
                                <td class="p-1" style="width:20px;">
                                  <a href="/posts/{{$s_post->id}}" class="link">
                                    <img src="{{url($proimg)}}" alt="" style="width: 20px; height: 20px;" class="rounded-circle m-0 p-0">
                                  </a>
                                </td>
                                <td class="text-left">
                                  <a href="/posts/{{$s_post->id}}" class="link">
                                    <h6 class="font-weight-bold text-dark text-capitalize" style="font-size: 12px;">{{$poster->first_name.' '.$poster->last_name}}</h6>
                                  </a>
                                </td>
                                <td class="text-left">
                                  <a href="/posts/{{$s_post->id}}" class="link">
                                    <h6 class="font-weight-bold text-dark text-capitalize" style="font-size: 12px;">{{$s_post->body_text}}</h6>
                                  </a>
                                </td>
                              </tr>
                            @endforeach
                          @else
                            <p class="mt-1">No Result Found</p>
                          @endif
                        </table>
                      </div>
                      <div class="tab-pane" role="tabpanel" id="tab-3">
                          <p>Content for tab 3.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link text-light" style="cursor: pointer;">
                <span class="caret fa fa-search link" style="color: #fff; font-size:15px;"></span>
              </a>
            </li>
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto mr-lg-5">
              <!-- Authentication Links -->
              @guest
                  <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                  <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
              @else
                  <li class="d-none d-lg-block">
                    <a class="nav-link text-light" href="/profile/{{Auth::id()}}/{{Auth::user()->last_name}}">
                      <?php
                        if(Auth::user()->profile_pic){
                          $med = App\Media::find(Auth::user()->profile_pic);
                          $img = '/storage/images/'.$med->url;
                        }
                        else {
                          if(Auth::user()->gender === 'male'){
                            $img = 'images/male.png';
                          }
                          else{
                            $img = 'images/female.png';
                          }
                        }
                      ?>
                      <span class="text-capitalize">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                      <img src="{{url($img)}}" alt="" class="rounded-circle img-responsive ml-2" style="width: 25px; height: 25px;">
                    </a>
                  </li>
                  <li style="border: 1px solid #7a7a7a;" class="mt-2 mb-2 d-none d-lg-block">
                  </li>
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      <span class="caret fa fa-users p-1 link" style="color: #fff; font-size:20px;"></span>
                    </a>

                    <div class="dropdown-menu rounded-0" aria-labelledby="navbarDropdown" style="width: 350px;">
                        <a class="font-weight-bold dropdown-header border link text-primary" href="/friend/requests">
                          {{ __('Friend Requests') }}
                        </a>
                        @include('inc.request')
                        <h6 class="font-weight-bold dropdown-header border text-secondary">{{ __('People you may know') }}</h6>
                        @include('inc.suggestion')
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="caret fa fa-envelope p-1 link" style="color: #fff; font-size:20px;"></span>
                    </a>

                    <div class="dropdown-menu rounded-0" aria-labelledby="navbarDropdown" style="width: 350px; left: -45px;">
                      <a class="font-weight-bold dropdown-header border link text-primary" href="/messanger/{{Auth::id()}}/{{Auth::id()}}">
                        {{ __('Messages') }}
                      </a>
                      @include('inc.messagebar')
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <span class="caret fa fa-globe p-1 link" style="color: #fff; font-size:20px;"></span>
                    </a>

                    <div class="dropdown-menu rounded-0" aria-labelledby="navbarDropdown" style="width: 350px; left: -89px;">
                        <a class="font-weight-bold dropdown-header border link text-primary" href="/messanger/{{Auth::id()}}/{{Auth::id()}}">
                          {{ __('Notifications') }}
                        </a>
                        @include('inc.notificationsbar')
                    </div>
                  </li>
                  <li style="border: 1px solid #7a7a7a;" class="mt-2 mb-2">
                  </li>
                  <li class="nav-item dropdown">
                      <a id="navbarDropdown" class="nav-link dropdown-toggle text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                          <span class="caret fa fa-gears p-2 link" style="color: #fff; font-size:15px;"></span>
                      </a>

                      <div class="dropdown-menu rounded-0" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
    </div>
</nav>
