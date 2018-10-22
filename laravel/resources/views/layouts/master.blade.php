@extends('layouts.app')
@section('body')
<body>
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')
</body>
@endsection