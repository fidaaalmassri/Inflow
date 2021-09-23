<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="javascript:;">
            <img src="{{asset('assets/images/icon.svg')}}" alt="" class="img-fluid logo"><span>Oculux</span>
        </a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu icon-close"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
            <img src="{{asset('assets/images/user-small.png') }}" class="user-photo" alt="">
            </div>
            <div class="dropdown">
                <strong> {{trans('lang.welcome')}}،
                <a href="" class="">
                {{auth()->user()->name}}</strong>
                </a>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="divider"></li>
                <li class="@yield('profile')">
                    <a href="{{route('profile',['id'=>auth()->user()->id])}}"><i class="icon-user"></i><span>  الملف الشحصي </span></a>
                </li>

                <li class="@yield('influences')">
                    <a href="{{route('all_influencers')}}"><i class="icon-users"></i><span>  المؤثرين </span></a>
                </li>

                <li><a href="{{route('logout')}}"><i class="icon-power"></i>تسجيل الخروج</a></li>
            </ul>
        </nav>
    </div>
