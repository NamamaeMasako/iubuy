<header id="header">
  <div class="container-fluid">

    <div id="logo" class="pull-left">
      <h1><a href="{{url("/index#intro")}}" class="scrollto">{{env('WEBSITE_NAME')}}</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="#intro"><img src="img/logo.png" alt="" title="" /></a>-->
    </div>

    <nav id="nav-menu-container" class="mr-5">
      <ul class="nav-menu">
        <li class="menu-active"><a href="{{url('/index#intro')}}">首頁</a></li>
        @if(Auth::check())
        <li class="menu-has-children"><a href="javascript:void(0);">功能列表</a>
          <ul>
            <li><a href="#">購物</a></li>
            <li><a href="#">討論</a></li>
          </ul>
        </li>
        @endif
        @if(Auth::check())
        <li class="menu-has-children">
          <a href="javascript:void(0);">
            {{Auth::user()->name}}
          </a>
          <ul>
            <li><a href="{{url('/member/'.\Auth::user()->id)}}">個人資料</a></li>
            <li><a href="{{url('/logout')}}">登出</a></li>
          </ul>
        </li>
        @else
        <li class="menu"><a href="{{url('/login')}}">登入</a></li>
        <li class="menu"><a href="{{url('/register')}}">註冊</a></li>
        @endif
      </ul>
    </nav><!-- #nav-menu-container -->
  </div>
</header><!-- #header -->