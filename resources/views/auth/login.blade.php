@extends('layouts.app')

@section('content')
 
 <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                     <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form login-logo">
                                    <div class="text-center mb-4">
                                            <a href="javascript:void(0)"><img src="{{asset('admin/images/logo.png')}}" alt=""></a>
                                    </div>
                                    <h4 class="mb-4">{{ __('Login') }}</h4>
                                    <form action="{{ route('login') }}" method="post">
                                         @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>{{ __('E-Mail Address') }}</strong></label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>{{ __('Password') }}</strong></label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- <div class="form-check custom-checkbox ms-1">
                                            <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                            <label class="form-check-label" for="basic_checkbox_1">Remember me</label>
                                        </div> -->
                                        <div class="mb-3 forgot-block">
                                            <!--<a href="forgot.html">Forgot Password?</a>-->
                                          @if (Route::has('password.request'))
                                            <a class="" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                         @endif  
                                 
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>
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
