@extends('layouts.master')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('content')
<section class="d-flex align-items-center justify-content-center">
    <div class="col-xl-8"> 
        <h2 class="text-center">{{env('WEBSITE_NAME')}} - 登入</h3>
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center">請輸入您的註冊資訊</h4>
            </div>
            <form method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <div class="card-body d-flex justify-content-center">
                    <div class="col-sm-8 pt-2">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="email">帳號(email)</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control bg-dark text-light" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="password">密碼</label>
                            <div class="col-md-8">
                                <input type="password" id="password" class="form-control bg-dark text-light" name="password"> 
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($errors) > 0)
                <div class="d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-dark">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card-footer border-top border-light d-flex justify-content-around">
                    <div class="col-sm-6 d-flex justify-content-center">
                        <a href="{{url('/index')}}" class="btn btn-lg btn-secondary mr-1">
                            <i class="fa fa-home mr-2"></i>回首頁
                        </a>
                        <button type="submit" class="btn btn-lg btn-success">
                            <i class="fa fa-sign-in mr-2"></i>登入
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection