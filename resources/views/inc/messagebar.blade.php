<div id="friendlist" class="card-body p-0 m-0" style="overflow: auto; overflow-x:hidden; max-width:">
  <?php
    $sentmes = App\Message::where('from_id', '=', Auth::id())->pluck('to_id');
    $recmes = App\Message::where('to_id', '=', Auth::id())->pluck('from_id');
    $senders = App\User::whereIn('id', $sentmes)->OrwhereIn('id', $recmes)->get();
  ?>
  <table class="table table-hover">
    @if(count($senders) > 0)
      @foreach($senders as $sender)
        <?php
          if($sender->profile_pic){
            $med = App\Media::find($sender->profile_pic);
            $img = '/storage/images/'.$med->url;
            $noPro = false;
          }
          else {
            $noPro = true;
            if($sender->gender === 'male'){
              $img = 'images/male.png';

            }
            else{
              $img = 'images/female.png';
            }
          }
        ?>
        <tr style="height: 45px;" class="m-0 p-0">
          <td style="width: 50px;">
            <a href="/messanger/{{Auth::id()}}/{{$sender->id}}" class="link">
              <img src="{{url($img)}}" alt=""  style="width: 40px; height: 40px;" class="m-0 p-0 rounded-circle float-left">
            </a>
          </td>
          <td class="text-left">
            <!-- Get last message-->
            <?php
              $lastmessage = App\Message::where('to_id', '=', Auth::id())->where('from_id', '=', $sender->id)->orderBy('created_at', 'desc')->first();
              if(count($lastmessage) > 0){
                $messpost = App\Post::find($lastmessage->post_id);

                if(strlen($messpost->body_text) > 20){
                  $mess = substr($messpost->body_text,0,17).'...';
                }
                else{
                  $mess = $messpost->body_text.'...';
                }
                $hasmedia = App\Post_Media::where('post_id', '=', $messpost->id)->get();
                if(count($hasmedia) > 0){
                  $mess = $sender->first_name.' '.'sent a photo...';
                }
              }
              else{
                $mess = 'No reply yet...';
              }
            ?>
            <a href="/messanger/{{Auth::id()}}/{{$sender->id}}" class="link">
              <h6 class="font-weight-bold">{{$sender->first_name.' '.$sender->last_name}}</h6>
              <p style="font-size:10px;" class="m-0">{{$mess}}</p>
            </a>
          </td>
        </tr>
      @endforeach
    @endif
  </table>
</div>
