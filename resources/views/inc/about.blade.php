<div class="col-9 text-left ml-auto pl-2 pr-0">
  <div class="card mb-4">
    <?php
      $fr1 = App\Friend::where('to_id', '=', $prouser->id)->where('status', '=', 'accepted')->pluck('from_id');
      $fr2 = App\Friend::where('from_id', '=', $prouser->id)->where('status', '=', 'accepted')->pluck('to_id');
      $frnds = App\User::whereIn('id', $fr1)->orWhereIn('id', $fr2)->orderBy('first_name', 'asc')->get();
    ?>
    <div class="card-header pl-2 pt-1 m-0 pb-0">
      <h5 class="font-weight-bold">Friend List</h5>
    </div>
    <div class="card-body row">
      @foreach($frnds as $frnd)
        <?php
          $promed = App\Media::find($frnd->profile_pic);
          if($frnd->profile_pic){
            $proimg = '/storage/images/'.$promed->url;
          }
          else{
            if($frnd->gender === 'male'){
              $proimg = '/images/male.png';
            }
            else{
              $proimg = '/images/female.png';
            }
          }
        ?>
        <div class="card col-2 m-2 p-0">
          <div class="card-body p-3">
            <a href="/profile/{{$frnd->id}}/{{$frnd->last_name}}" class="link text-primary">
              <img src="{{url($proimg)}}" alt="" style="width: 100%; height: 100px;" class="rounded-0">
            </a>
          </div>
          <div class="card-footer m-0 p-1">
            <a href="/profile/{{$frnd->id}}/{{$frnd->last_name}}" class="link text-primary">
              <h6 class="font-weight-bold text-center text-capitalize">{{$frnd->first_name.' '.$frnd->last_name}}</h6>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
