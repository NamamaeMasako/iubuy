@extends('layouts.master')
@section('content')
<section class="d-flex align-items-start justify-content-center">
    <div class="col-md-8 d-md-flex align-items-start justify-content-center">
        <div class="col-xl-3 col-md-5 col-sm-12">
        	@yield('three')
        </div>
        <div class="col-xl-9 col-md-7 col-sm-12">
        	@yield('nine')
        </div>
    </div>
 </section>
@endsection