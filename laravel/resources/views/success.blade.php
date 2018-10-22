@extends('layouts.master')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('content')
<section class="d-flex align-items-center justify-content-center">
    <div class="col-md-6"> 
        <h2 class="text-center">{{env('WEBSITE_NAME')}} - 註冊成功</h3>
        <div class="card text-center">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title">恭喜您已成為本站會員!</h4>
            </div>
            <div class="card-body">
                請立即登入並驗證您的會員,以完善在本站的瀏覽體驗
            </div>
            <div class="card-footer border-top border-light">
                <a href="{{url('/index')}}" class="btn btn-secondary">
                    <i class="fa fa-home mr-1"></i>回首頁
                </a>
                <a href="{{url('/login')}}" class="btn btn-success">
                    <i class="fa fa-sign-in mr-1"></i>登入
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
