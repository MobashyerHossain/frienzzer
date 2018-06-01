@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="title m-b-md d-none d-lg-block text-light" style="margin-top:35vh;">
        {{ config('app.name', 'FRIENZZER') }}
      </div>
    </div>
    <div class="col-lg-6" style="margin-top:7vh;" >
      <div class="row justify-content-center">
          <div class="col-md-11">
            <div class="card" style="background-color: #fff; opacity: .6; height:100%; width:94%; z-index:-1; position:absolute;">

            </div>
            <div class="card" style="box-shadow: 10px 10px 20px black; border-radius:0px; background-color: transparent; z-index:1;">
                <div class="text-dark font-weight-bold p-2" style="font-size:20px; border-radius:0px;">
                  {{ __('Register') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input id="name" style=" border-top:none; border-right:none; border-left:none; text-transform:capitalize; box-shadow:none !important;" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required placeholder="First Name">

                                @if ($errors->has('first_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input id="name" style=" border-top:none; border-right:none; border-left:none; text-transform:capitalize; box-shadow:none !important;" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required placeholder="Last Name">

                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input id="name" style=" border-top:none; border-right:none; border-left:none; box-shadow:none !important;" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required placeholder="Mobile Number">

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input id="email" style=" border-top:none; border-right:none; border-left:none; box-shadow:none !important;" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input id="password" style=" border-top:none; border-right:none; border-left:none; box-shadow:none !important;" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input id="password-confirm" style=" border-top:none; border-right:none; border-left:none; box-shadow:none !important;" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birth_date" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('Birth Date') }}</label>

                            <div class="col-md-8 col-10 ml-auto mr-auto">
                                <input style=" border-top:none; border-right:none; border-left:none; box-shadow:none !important;" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" required placeholder="Date of Birth">

                                @if ($errors->has('birth_date'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="d-none d-md-block text-dark font-weight-bold col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-8 col-12 mt-2 text-dark font-weight-bold">
                              <input type="radio" name="gender" value="male" class="form-horizontal" checked> Male
                              <input type="radio" name="gender" value="female" class="form-horizontal ml-4"> Female
                              <input type="radio" name="gender" value="other" class="form-horizontal ml-4"> Other
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary mr-sm-4">
                                    {{ __('Register') }}
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-primary ml-sm-4">
                                    {{ __('Login') }}
                                </a>
                            </div>
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
