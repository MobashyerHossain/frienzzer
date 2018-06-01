@extends('layouts.app')

@section('content')
  @include('inc.sidebar')
  <div class="col-lg-8 col-md-10">
    @include('inc.showposts')
  </div>
@include('inc.rightsidebar')
@endsection
