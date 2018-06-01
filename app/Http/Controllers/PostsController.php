<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use App\Media;
use App\Post_media;
use App\Message;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $medias = Media::where('user_id', '=', $request->input('user_id'))->where('relation','=', 'temp')->get();
        if(count($medias) == 0){
          $this->validate($request, [
            'body' => 'required'
          ]);
        }
        //create posts
        $post = new Post;
        $post->user_id = $request->input('user_id');
        $post->type = $request->input('type');
        $post->body_text = $request->input('body');
        $post->save();

        if(count($medias) > 0){
          foreach ($medias as $media) {
            $media->relation = 'post';
            $media->save();
            $post_media = new Post_media;
            $post_media->post_id = $post->id;
            $post_media->media_id = $media->id;
            $post_media->save();
          }
        }

        if($request->input('type') === 'message'){
          $message = new Message;
          $message->from_id = $request->input('user_id');
          $message->to_id = $request->input('to_id');
          $message->post_id = $post->id;
          $message->save();
          return redirect('/messanger'.'/'.$message->from_id.'/'.$message->to_id);
        }
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post',$post);
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
      $this->validate($request, [
        'body' => 'required'
      ]);
      //create posts
      $post = Post::find($id);
      $post->body_text = $request->input('body');
      $post->save();
      return redirect('/posts')->with('Success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts')->with('Success', 'Post Removed');
    }
}
