@extends('layouts.master')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('content')
<section class="d-flex align-items-center justify-content-center">
    <div class="col-xl-8"> 
        <h2 class="text-center">{{env('WEBSITE_NAME')}} - 註冊</h3>
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center">以下欄位皆為必填</h4>
            </div>
            <form method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}
                <div class="card-body d-flex justify-content-center">
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="account">帳號</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control bg-dark text-light" name="account" placeholder="請輸入至少六碼英數字" value="{{ old('account') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">暱稱</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control bg-dark text-light" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">性別</label>
                            <div class="col-md-8">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-secondary" onclick="radio_check.call(this);">
                                        <input type="radio" name="gender" autocomplete="off" value="male" @if(old('gender') == 'male') checked @endif>男
                                    </label>
                                    <label class="btn btn-outline-secondary" onclick="radio_check.call(this);">
                                        <input type="radio" name="gender" autocomplete="off" value="female" @if(old('gender') == 'female') checked @endif>女
                                    </label>
                                    <label class="btn btn-outline-secondary" onclick="radio_check.call(this);">
                                        <input type="radio" name="gender" autocomplete="off" value="other" @if(old('gender') == 'other') checked @endif>其他
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="email">電子信箱</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control bg-dark text-light" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="email">手機</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control bg-dark text-light" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="password">密碼</label>
                            <div class="col-md-8">
                                <input type="password" id="password" class="form-control bg-dark text-light" name="password"> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="password_confirmation">密碼確認</label>
                            <div class="col-md-8">
                                <input type="password" id="password_confirmation" class="form-control bg-dark text-light" name="password_confirmation"> 
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-8 offset-md-3 text-left">
                                <input type="checkbox" name="agreement"> 我同意提供個人資料
                            </label>
                        </div>
                        <div class="row">
                            <label class="col-md-8 offset-md-3 text-left">
                                {!! app('captcha')->display(); !!}
                            </label>
                        </div>
                    </div>
                </div>
                @if (count($errors) > 0)
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
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
                <div class="card-footer text-center border-top border-light">
                    <a href="{{url('/index')}}" class="btn btn-secondary mr-1">
                        <i class="fa fa-home mr-2"></i>回首頁
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-sign-in mr-2"></i>註冊
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    function radio_check() {
        $(this).parent().children('label').removeClass('btn-secondary btn-outline-secondary');
        $(this).addClass('btn-secondary');
        $(this).siblings('label').addClass('btn-outline-secondary');
    }
</script>
@endsection
