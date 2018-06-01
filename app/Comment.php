<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function commentPost() {
      return $this->belongsTo('App\Post');
    }

    /*public function postComment() {
      return $this->hasMany('App\Comment');
    }*/
}
