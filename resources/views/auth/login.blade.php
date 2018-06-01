@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="title m-b-md d-none d-lg-block text-light" style="margin-top:35vh;">
        {{ config('app.name', 'FRIENZZER') }}
      </div>
    </div>
    <div class="col-lg-6" style="margin-top:22vh;">
      <div class="row justify-content-center">
          <div class="col-md-11">
            <div class="card" style="background-color: #fff; opacity: .6; height:100%; width:94%; z-index:-1; position:absolute;">

            </div>
            <div class="card" style="box-shadow: 10px 10px 20px black; border-radius:0px; background-color: transparent; z-index:1;">
                <div class="text-dark font-weight-bold p-2" style="font-size:20px; border-radius:0px;">
                  {{ __('Login') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-7 col-10 ml-auto mr-auto">
                                <input id="email" style="box-shadow:none !important; border-top:none; border-right:none; border-left:none;" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete = "off" placeholder="Email">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-right">{{ __('Password') }}</label>

                            <div class="col-md-7 col-10 ml-auto mr-auto">
                                <input id="password" style="box-shadow:none !important; border-top:none; border-right:none; border-left:none;" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete = "off" placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 ml-auto mr-auto text-dark font-weight-bold">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary mr-sm-4">
                                    {{ __('Login') }}
                                </button>
                                <a href="{{ route('register') }}" class="btn btn-primary ml-sm-4" >
                                    {{ __('Register') }}
                                </a>

                            </div>
                        </div>

                        <div class="form-group row mb-1">
                          <a class="btn btn-link ml-auto mr-auto font-weight-bold link text-primary" href="">
                              {{ __('Forgot Your Password?') }}
                          </a>
                        </div>
                    </form>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
