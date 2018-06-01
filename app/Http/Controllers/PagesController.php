<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
  public function index()
  {
    if(!isset($_SESSION)){
      return redirect('posts');
    }
    else{
      return view('welcome');
    }
  }

  public function profile()
  {
      return view('pages/profile');
  }

  public function messanger()
  {
      return view('pages/messanger');
  }

  public function request()
  {
      return view('pages/friendrequests');
  }
}
