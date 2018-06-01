<?php

namespace App\Http\Controllers;

use App\User;
use App\Media;
use App\Post;
use App\Post_Media;
use App\Message;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'url' => 'image|required|max:1999'
        ]);

        // Handle file upload
        if($request->hasFile('url')){
          // filename with .ext
          $filenameExt = $request->file('url')->getClientOriginalName();
          // filename without .ext
          $filename = pathinfo($filenameExt, PATHINFO_FILENAME);
          // get .ext
          $extension = $request->file('url')->getClientOriginalExtension();
          // stored path
          $newfilename = $filename.'_'.time().'.'.$extension;
          // upload image
          $path = $request->file('url')->storeAs('public/images', $newfilename);
        }
        else{
          return $request;
        }

        //create media
        $media = new Media;
        $media->user_id = $request->input('user_id');
        $media->relation = $request->input('relation');
        $media->media_type = $request->input('media_type');
        $media->url = $newfilename;
        $media->save();

        //handle Message images
        if($request->input('dst') === 'message'){
          $media->relation = 'post';
          $media->save();
          $post = new Post;
          $post->user_id = $media->user_id;
          $post->type = 'message';
          $post->save();
          $post_media = new Post_Media;
          $post_media->post_id = $post->id;
          $post_media->media_id = $media->id;
          $post_media->save();
          $message = new Message;
          $message->from_id = $media->user_id;
          $message->to_id = $request->input('to_id');
          $message->post_id = $post->id;
          $message->save();
          return redirect('/messanger'.'/'.$media->user_id.'/'.$request->input('to_id'));
        }

        //handle profile picture
        if($request->input('relation') === 'propic'){
          $user = User::find($request->input('user_id'));
          $user->profile_pic = $media->id;
          $user->save();
          if($request->input('redirect') === 'profile'){
            return redirect('/profile'.'/'.$user->id.'/'.$user->last_name);
          }
        }

        //handle cover picture
        if($request->input('relation') === 'coverpic'){
          $user = User::find($request->input('user_id'));
          $user->cover_pic = $media->id;
          $user->save();
          return redirect('/profile'.'/'.$user->id.'/'.$user->last_name);
        }
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
