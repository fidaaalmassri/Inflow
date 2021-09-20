<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <title> Oculux | انشاء حساب</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/animate-css/vivify.min.css')}}">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/site.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

</head>


@if(App::getLocale() == 'ar')
<body class="theme-cyan light_version rtl">
@else
<body class="theme-cyan light_version ltr">
@endif
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
    </div>
</div>

<div class="pattern">
    <span class="red"></span>
    <span class="indigo"></span>
    <span class="blue"></span>
    <span class="green"></span>
    <span class="orange"></span>
</div>
<div class="auth-main particles_js">
    <div class="auth_div vivify popIn">
        <div class="auth_brand">
        <a class="navbar-brand" href="javascript:void(0);"><img src="{{asset('assets/images/icon.svg')}}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Oculux</a>
        </div>
        <div class="card">
            <div class="body">
                <p class="lead">{{trans('lang.company_sign_up')}}</p>
                <form class="form-auth-small m-t-20">


                <div class="form-group">

                <input id="company_name" placeholder="{{trans('lang.company_name')}}" type="text" class="form-control round @error('company_name') is-invalid @enderror" name="name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus>
                </div>
        <div class="form-group">

            <input id="company_link" placeholder="{{trans('lang.company_link')}}" type="text" class="form-control round @error('company_link') is-invalid @enderror" name="name" value="{{ old('company_link') }}" required autocomplete="company_link" autofocus>
            </div>



            <div class="form-group">

<input id="fname" placeholder="{{trans('lang.fname')}}" type="text" class="form-control round @error('fname') is-invalid @enderror" name="name" value="{{ old('fname') }}" required autocomplete="fname" autofocus>
</div>
<div class="form-group">

<input id="lname" placeholder="{{trans('lang.lname')}}" type="text" class="form-control round @error('lname') is-invalid @enderror" name="name" value="{{ old('lname') }}" required autocomplete="lname" autofocus>
</div>


                    <div class="form-group">
                        <input type="email" class="form-control round" placeholder="{{trans('lang.email')}}">
                    </div>
                    <div class="form-group">                            
                        <input type="password" class="form-control round" placeholder="{{trans('lang.password')}}">
                    </div>

                    <div class="form-group">                            
                        <input type="confirm-password" class="form-control round" placeholder="{{trans('lang.Confirm-password')}}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-round btn-block">{{trans('lang.Register')}}</button>                                
                </form>

               
            </div>

            <div class="bottom">
                        <span class="helper-text"> {{trans('lang.ALREADY_USING')}}<a href="{{route('login')}}">{{trans('lang.Login')}}</a></span>
                    </div>
                
        </div>
    </div>
    <div id="particles-js"></div>
</div>
<!-- END WRAPPER -->

<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
</body>
</html>