@extends('layouts.app')

@section('body')
<body class="register-page">
    <div class="register-box"> 
        <div class="register-logo">
            <h3>{{env('WEBSITE_NAME')}} 後台 - 註冊</h3>
        </div>
        <div class="card">
            <form method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}
                <div class="card-body">
                    <p class="login-box-msg">以下欄位皆為必填</p>
                    <div class="form-group has-feedback">
                        <label for="name">管理員名稱</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="email">帳號(email)</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password">密碼</label>
                        <div class="input-group">
                            <input type="password" id="password" class="form-control" name="password"> 
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password_confirmation">密碼</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"> 
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <label class="form-control border-0 text-left">
                                <input type="checkbox" name="agreement" class="flat-red"> 我同意提供個人資料
                            </label>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-sign-in mr-2"></i>註冊
                                </button>
                            </span>
                        </div>
                    </div>
                    {{-- <div class="form-group has-feedback">
                        <label class="col-md-4 control-label"></label>

                        <div class="col-md-6">
                            {!! app('captcha')->display(); !!}
                        </div>

                    </div> --}}
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
@endsection
