<div id="friendlist" class="card-body p-0 m-0" style="overflow: auto; overflow-x:hidden; max-width:">
  <?php
    $notifications = App\Notification::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();
  ?>
  <table class="table table-hover">
    @if(count($notifications) > 0)
      @foreach($notifications as $notification)
        <tr style="height: 45px;" class="m-0 p-0">
          <td class="text-left">
            <!-- Get shorten notification message-->
            <?php
              if(strlen($notification->body) > 20){
                $mess = substr($notification->body,0,17).'...';
              }
              else{
                $mess = $notification->body.'...';
              }
            ?>
            <a href="/messanger/{{Auth::id()}}/{{$sender->id}}" class="link">
              <p style="font-size:10px;" class="m-0">{{$mess}}</p>
            </a>
          </td>
        </tr>
      @endforeach
    @else
    <tr class="m-0 p-0">
      <td class="text-center">
        <p style="font-size:15px;" class="m-0">No New Notification</p>
      </td>
    </tr>
    @endif
  </table>
</div>
