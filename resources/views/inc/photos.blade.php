<div class="col-9 text-left ml-auto pl-2 pr-0">
  <?php
    $prophotos = App\Media::where('user_id', '=', $prouser->id)->where('relation', '=', 'propic')->get();
    $covphotos = App\Media::where('user_id', '=', $prouser->id)->where('relation', '=', 'coverpic')->get();
    $postphotos = App\Media::where('user_id', '=', $prouser->id)->where('relation', '=', 'post')->get();
  ?>

  <!-- Profile Pics-->
  <div class="card mb-4">
    <div class="card-header pl-2 pt-1 m-0 pb-0">
      <h5 class="font-weight-bold">Profile Pictures</h5>
    </div>
    <div class="card-body row">
      @foreach($prophotos as $prophoto)
        <?php
          $pro = '/storage/images/'.$prophoto->url;
        ?>
        <div class="card col-lg-2 m-2 p-0 col-md-3 col-12 col-sm-5">
          <div class="card-body p-2">
            <a data-toggle="modal" data-target="#mediaModal{{$prophoto->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
              <img src="{{url($pro)}}" alt="" style="width: 100%; height: 100px;" class="rounded-0">
            </a>
          </div>
        </div>

        <!-- Media Modal -->
        <div class="modal fade bd-example-modal-lg" id="mediaModal{{$prophoto->id}}" tabindex="-1" aria-labelledby="mediaModalTitle{{$prophoto->id}}" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-dark p-1">
                <h5 class="modal-title text-light" id="mediaModalTitle{{$prophoto->id}}">Profile Pictures of {{$prouser->first_name.' '.$prouser->last_name}}</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body bg-dark p-1">
                <img src="{{url($pro)}}" alt="" style="width: 100%;" class="p-2">
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Cover Pics-->
  <div class="card mb-4">
    <div class="card-header pl-2 pt-1 m-0 pb-0">
      <h5 class="font-weight-bold">Cover Pictures</h5>
    </div>
    <div class="card-body row">
      @foreach($covphotos as $covphoto)
        <?php
          $cov = '/storage/images/'.$covphoto->url;
        ?>
        <div class="card col-lg-2 m-2 p-0 col-md-3 col-12 col-sm-5">
          <div class="card-body p-2">
            <a data-toggle="modal" data-target="#mediaModal{{$covphoto->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
              <img src="{{url($cov)}}" alt="" style="width: 100%; height: 100px;" class="rounded-0">
            </a>
          </div>
        </div>

        <!-- Media Modal -->
        <div class="modal fade bd-example-modal-lg" id="mediaModal{{$covphoto->id}}" tabindex="-1" aria-labelledby="mediaModalTitle{{$covphoto->id}}" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-dark p-1">
                <h5 class="modal-title text-light" id="mediaModalTitle{{$covphoto->id}}">Cover Photos of {{$prouser->first_name.' '.$prouser->last_name}}</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body bg-dark p-1">
                <img src="{{url($cov)}}" alt="" style="width: 100%;" class="p-2">
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Post Pics-->
  <div class="card mb-4">
    <div class="card-header pl-2 pt-1 m-0 pb-0">
      <h5 class="font-weight-bold">Shared Pictures</h5>
    </div>
    <div class="card-body row">
      @foreach($postphotos as $postphoto)
        <?php
          $postp = '/storage/images/'.$postphoto->url;
        ?>
        <div class="card col-lg-2 m-2 p-0 col-md-3 col-12 col-sm-5">
          <div class="card-body p-2">
            <a data-toggle="modal" data-target="#mediaModal{{$postphoto->id}}" class="mt-2 p-0 font-weight-bold text-dark link nav-link" style="cursor: pointer;">
              <img src="{{url($postp)}}" alt="" style="width: 100%; height: 100px;" class="rounded-0">
            </a>
          </div>
        </div>

        <!-- Media Modal -->
        <div class="modal fade bd-example-modal-lg" id="mediaModal{{$postphoto->id}}" tabindex="-1" aria-labelledby="mediaModalTitle{{$postphoto->id}}" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-dark p-1">
                <h5 class="modal-title text-light" id="mediaModalTitle{{$postphoto->id}}">Shared Photos of {{$prouser->first_name.' '.$prouser->last_name}}</h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close" style="border:none; cursor:pointer; outline: none; resize: none; box-shadow:none !important">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body bg-dark p-1">
                <img src="{{url($postp)}}" alt="" style="width: 100%;" class="p-2">
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
