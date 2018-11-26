@extends('layouts.app')

@section('body')
<body class="login-page">
    <div class="login-box"> 
        <div class="login-logo">
            <h3>{{env('WEBSITE_NAME')}} 後台 - 登入</h3>
        </div>
        <div class="card">
            <form method="POST" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="email">帳號(email)</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">密碼</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"> 
                            <a href="{{url('/forgetPassword')}}" class="btn btn-secondary btn-flat disabled">忘記密碼</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="form-control border-0 text-left">
                                <input type="checkbox" name="remember" class="flat-red">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Captcha::display(); !!}
                    </div>
                    <div class="form-group">
                        <div class="input-group justify-content-around">
                            @if(count(App\User::all()) <= 0)
                                <a href="{{url('/register')}}" class="btn btn-success">註冊</a>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-sign-in mr-2"></i>登入
                            </button>
                        </div>
                    </div>
                </div>
                @if (count($errors) > 0)
                <div class="card-footer">
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif    
            </form>
        </div>
    </div>
</body>
@endsection
