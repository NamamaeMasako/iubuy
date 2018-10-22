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
                    <div class="form-group has-feedback">
                        <label for="email">帳號(email)</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="password">密碼</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password"> 
                            <span class="input-group-btn">
                                <a href="{{url('/forgetPassword')}}" class="btn btn-secondary btn-flat disabled">忘記密碼</a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <div class="input-group">
                            <label class="form-control border-0 text-left">
                                <input type="checkbox" name="remember" class="flat-red">
                                Remember Me
                            </label>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-sign-in mr-2"></i>登入
                                </button>
                                @if(count(App\User::all()) <= 0)
                                    <a href="{{url('/register')}}" class="btn btn-success">註冊</a>
                                @endif
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
