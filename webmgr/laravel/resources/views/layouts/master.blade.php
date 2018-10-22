@extends('layouts.app')
@section('body')
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.header')
        @include('layouts.navigation')
        <div class="content-wrapper">
        	@yield('content')
        </div>
        @include('layouts.message')
    </div>
</body>
@endsection