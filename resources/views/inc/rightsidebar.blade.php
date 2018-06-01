<div class="col-md-2 sidenav p-2 d-none d-md-block"  style="background-color:transparent;">
  <?php
    $list1 = App\Friend::where('to_id', '=', Auth::id())->where('status', '=', 'accepted')->pluck('from_id');
    $list2 = App\Friend::where('from_id', '=', Auth::id())->where('status', '=', 'accepted')->pluck('to_id');
    $friendlist = App\User::whereIn('id', $list1)->orWhereIn('id', $list2)->get();
  ?>
  <script>
    $(document).ready(function(){
      $("#searchfriend").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#friendlist #friend").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>

  <div class="card" style="width:200px; height:90vh; position:fixed; z-index: 0 !important;">
    <div class="card-header text-left p-1 font-weight-bold">
      Friend list
    </div>
    <div id="friendlist" class="card-body p-0 m-0" style="overflow: auto;">
      <table class="table table-hover">
        @if(count($friendlist) > 0)
          @foreach($friendlist as $flist)
            <tr id="friend">
              <td class="p-1" style="width:20px;">
                <?php
                  $promed = App\Media::find($flist->profile_pic);
                  if($flist->profile_pic){
                    $proimg = '/storage/images/'.$promed->url;
                  }
                  else{
                    if($flist->gender === 'male'){
                      $proimg = '/images/male.png';
                    }
                    else{
                      $proimg = '/images/female.png';
                    }
                  }
                 ?>
                <a href="/messanger/{{Auth::id()}}/{{$flist->id}}" class="link">
                  <img src="{{url($proimg)}}" alt="" style="width: 20px; height: 20px;" class="rounded-circle mt-1 m-0 p-0">
                </a>
              </td>
              <td class="text-left">
                <a href="/messanger/{{Auth::id()}}/{{$flist->id}}" class="link">
                  <h6 class="font-weight-bold text-dark text-capitalize" style="font-size: 12px;">{{$flist->first_name.' '.$flist->last_name}}</h6>
                </a>
              </td>
              <td class="text-right">
                <a href="/profile/{{$flist->id}}/{{$flist->last_name}}" class="link m-0 p-0">
                  <span class="text-primary fa fa-info-circle m-0 p-0" style="font-size: 20px;"></span>
                </a>
              </td>
            </tr>
          @endforeach
        @else
          <p class="mt-1">No Friends Yet</p>
        @endif
      </table>
    </div>
    <input id="searchfriend" class="p-2" type="text" style="width: 200px; border:none; box-shadow:none !important; outline: none;" placeholder="Search...">
  </div>
</div>
