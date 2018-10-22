<nav class="main-header navbar navbar-expand border-bottom 
@if(Auth::user()->admin == 0)
navbar-dark bg-primary 
@elseif(Auth::user()->admin == 1)
navbar-light bg-white
@endif">
	<!-- Left navbar links -->
  <ul class="navbar-nav">
    	<li class="nav-item">
      	<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    	</li>
    	<li class="nav-item d-none d-sm-inline-block">
      	<a href="{{str_replace('/webmgr','',url('/index'))}}" class="nav-link" target="_blank"><i class="fa fa-home mr-1"></i>前台</a>
    	</li>
  </ul>
  <!-- SEARCH FORM -->
  <form action="https://www.google.com.tw/search" id="search-form" method="get" class="form-inline ml-3" target="_blank">
    	<div class="input-group input-group-sm">
        <div class="input-group-append">
          <span class="btn btn-navbar dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-google" id="search-icon"></i>
          </span>
          <ul class="dropdown-menu p-1" id="all-engine">
            <li class="btn active dropdown-item" id="google" onclick="change_search('google')"><i class="fa fa-google mr-2"></i>Google</li>
            <li class="btn dropdown-item" id="yahoo" onclick="change_search('yahoo')"><i class="fa fa-yahoo mr-2"></i>Yahoo</li>
            <li class="btn dropdown-item" id="youtube" onclick="change_search('youtube')"><i class="fa fa-youtube mr-2"></i>Youtube</li>
          </ul>
        </div>
      	<input class="form-control form-control-navbar" name="q" id="search-input" type="search" placeholder="Search..." aria-label="Search">
      	<div class="input-group-append">
        		<button class="btn btn-navbar" type="submit">
          		<i class="fa fa-search"></i>
        		</button>
      	</div>
    	</div>
  </form>
</nav>
