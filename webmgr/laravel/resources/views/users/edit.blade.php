@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-id-card-o mr-1"></i>管理中心<small><i class="fa fa-chevron-right m-1"></i>編輯管理員</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/users')}}">管理中心</a></li>
                    <li class="breadcrumb-item active">編輯管理員</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul class="m-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <form action='{{url('/users/edit/'.$tb_Users->id)}}' method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="name" class="col-sm-1">管理員名稱</label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="name" class="form-control" value="{{ $tb_Users->name }}" @if(Auth::user()->id != $tb_Users->id) readonly @endif>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="email" class="col-sm-1">帳號(Email)</label>
                            <div class="col-sm-5">
                                <input type="email" id="email" name="email" class="form-control" value="{{ $tb_Users->email }}" disabled>
                            </div>
                        </div>
                        @if(Auth::user()->admin == 0)
                        <div class="row form-group">
                            <label for="admin" class="col-sm-1">*權限等級</label>
                            <div class="col-sm-5">
                                <select id="admin" name="admin" class="form-control">
                                    <option value="1" @if($tb_Users->admin == 1) selected @endif>一般</option>
                                    <option value="0" @if($tb_Users->admin == 0) selected @endif>最高</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        @if(Auth::user()->id == $tb_Users->id)
                        <div class="row form-group">
                            <div id="accordion" class="col-sm-5 offset-sm-1">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                            <h3 class="card-title">修改密碼</h3>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="card-body">
                                            <div class="row form-group">
                                                <label for="old_password" class="col-sm-3">*舊密碼</label>
                                                <div class="col-sm-6">
                                                    <input type="password" id="old_password" name="old_password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="password" class="col-sm-3">*新密碼</label>
                                                <div class="col-sm-6">
                                                    <input type="password" id="password" name="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="password_confirmation" class="col-sm-3">*確認新密碼</label>
                                                <div class="col-sm-6">
                                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row form-group">
                            <label class="col-sm-1">管理員頭像</label>
                            <div class="col-sm-5">
                                <label for="avator" class="btn btn-info btn-sm mb-1"><i class="fa fa-share"></i>上傳</label>
                                <span id="show_fileInfo">(僅限上傳jpg,png,gif檔案,大小:250x250)</span>
                                <input type="file" id="avator" name="avator" style="display: none;" onchange="show_fileInfo();">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title"><small>目前頭像</small></h4>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{url('upload/users/'.$tb_Users->avator)}}" class="col-sm-12 img-circle elevation-2" alt="User Image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/users') }}" class="btn btn-secondary">
                            <i class="fa fa-reply mr-1"></i>返回會員列表
                        </a>
                        <button type="submit"  class="btn btn-primary">
                            更新
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    function show_fileInfo() {
        var info = $('#avator').val();
        $('#show_fileInfo').text(info);
    }
</script>
@endsection