<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{url('img/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{env('WEBSITE_NAME')}} 後台</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <a href="{{url('/users/edit/'.Auth::user()->id)}}" class="d-flex">
                <div class="image">
                    <img src="{{url('upload/users/'.Auth::user()->avator)}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <span class="d-block">{{Auth::user()->name}}</span>
                </div>
            </a>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="sidebar-menu">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{url('/dashbroad')}}" class="nav-link" id="dashbroad">
                        <i class="nav-icon fa fa-star"></i>
                        <p>總覽</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/users')}}" class="nav-link" id="users">
                        <i class="nav-icon fa fa-id-card-o"></i>
                        <p>管理中心</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/members')}}" class="nav-link" id="members">
                        <i class="nav-icon fa fa-users"></i>
                        <p>會員中心</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/shops')}}" class="nav-link" id="shops">
                        <i class="nav-icon fa fa-shopping-bag"></i>
                        <p>商家中心</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/products')}}" class="nav-link" id="products">
                        <i class="nav-icon fa fa-gift"></i>
                        <p>商品中心</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/logout')}}" class="nav-link">
                        <i class="nav-icon fa fa-sign-out"></i>
                        <p>
                            登出
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>