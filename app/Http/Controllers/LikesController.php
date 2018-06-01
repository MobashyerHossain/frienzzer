<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikesController extends Controller
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
        try {
          //create Likes
          $like = new Like;
          $like->post_id = $request->input('post');
          $like->user_id = $request->input('user');
          $like->save();
        } catch (\Exception $e) {
          return $e;
        }

        if($request->input('dst') === 'message'){
          return redirect('/messanger'.'/'.$like->user_id.'/'.$request->input('to_id'));
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
    public function destroy(Request $request, $id)
    {
        $like = Like::where('user_id', $request->input('user'))->where('post_id', $id);
        $like->delete();

        if($request->input('dst') === 'message'){
          return redirect('/messanger'.'/'.$request->input('user').'/'.$request->input('to_id'));
        }

        return redirect('/posts');
    }
}
