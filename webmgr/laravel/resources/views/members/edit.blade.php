@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-users mr-1"></i>會員中心<small><i class="fa fa-chevron-right m-1"></i>編輯會員</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/members')}}">會員中心</a></li>
                    <li class="breadcrumb-item active">編輯會員</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body d-flex align-items-start">
                    <div class="col-sm-6 d-inline-block">
                        <div class="row form-group">
                            <label for="Name" class="col-sm-2">會員暱稱</label>
                            <div class="input-group col-sm-6">
                                <input type="text" id="Name" class="form-control" value="{{ $tb_Members->name }}" disabled>
                                <span class="input-group-append">
                                    <span class="btn btn-warning" onclick="reset_confirm('nameReset');">重設</span>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="email" class="col-sm-2">帳號(Email)</label>
                            <div class="col-sm-6">
                                <input type="email" id="email" class="form-control" value="{{ $tb_Members->email }}" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div id="accordion" class="col-sm-6 offset-sm-2">
                                <span class="btn btn-warning" onclick="reset_confirm('passwordReset');">重設密碼</span>
                            </div>
                        </div>
                        @if(Auth::user()->admin == 0)
                        <div class="row form-group">
                            <label for="admin" class="col-sm-2">階級</label>
                            <div class="col-sm-6">
                                <select id="admin" class="form-control" onchange="reset_confirm('adminReset',this.value);">
                                    <option value="0" @if($tb_Members->admin == 0) selected @endif>一般</option>
                                    <option value="1" @if($tb_Members->admin == 1) selected @endif>高級</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="row form-group">
                            <label for="premission" class="col-sm-2">權限</label>
                            <div class="col-sm-6">
                                <select id="premission" class="form-control" onchange="reset_confirm('premissionReset',this.value);">
                                    <option value="1" @if($tb_Members->premission == 1) selected @endif>開放</option>
                                    <option value="0" @if($tb_Members->premission == 0) selected @endif>停權</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2">會員頭像</label>
                            <div class="col-sm-6"> 
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title"><small>目前頭像</small></h4>
                                                <div class="card-tools">
                                                    <span class="btn btn-sm btn-warning mb-1" onclick="reset_confirm('avatorReset');">重設</span>
                                                </div>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{url('upload/members/'.$tb_Members->avator)}}" class="col-sm-12 img-circle elevation-2" alt="User Image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{url('/members/edit/'.$tb_Members->id)}}" class="col-sm-5 d-inline-block" method="post">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="card card-info">
                            <div class="card-header">
                                <h4 class="card-title">送貨資訊</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="row form-group">
                                        <label for="infoName" class="col-sm-2">收件人</label>
                                        <div class="input-group col-sm-5">
                                            <input type="text" class="form-control" id="infoName" name="info_name" value="{{json_decode($tb_Members->info)->name}}" required>
                                        </div>
                                        <div class="input-group col-sm-3">
                                            <label for="male" class="pr-3">
                                                <input type="radio" id="male" name="gender" class="flat-red" value="male" 
                                                @if(json_decode($tb_Members->info)->gender == 'male') checked @endif>
                                                先生
                                            </label>
                                            <label for="female">
                                                <input type="radio" id="female" name="gender" class="flat-red" value="female"
                                                @if(json_decode($tb_Members->info)->gender == 'female') checked @endif>
                                                小姐
                                            </label>
                                        </div>
                                    </div>
                                    <div id="email-input" class="row form-group">
                                        <label for="infoEmail" class="col-sm-2">電子郵件</label>
                                        @foreach(json_decode($tb_Members->info)->email  as $idx => $row)
                                            @if($idx == 0)
                                            <div class="input-group col-sm-8">
                                                <input type="email" name="info_email[]" class="form-control" value="{{$row}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="btn btn-success" onclick="increase_input('email','email');"><i class="fa fa-plus"></i></span>
                                                </div>
                                            </div>
                                            @else
                                            <div class="input-group col-sm-8 offset-sm-2 mt-1">
                                                <input type="text" name="info_email[]" class="form-control" value="{{$row}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="btn btn-danger" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div id="phone-input" class="row form-group">
                                        <label for="infoPhone" class="col-sm-2">連絡電話</label>
                                        @foreach(json_decode($tb_Members->info)->phone  as $idx => $row)
                                            @if($idx == 0)
                                            <div class="input-group col-sm-8">
                                                <input type="text" name="phone[]" class="form-control" value="{{$row}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="btn btn-success" onclick="increase_input('phone','text');"><i class="fa fa-plus"></i></span>
                                                </div>
                                            </div>
                                            @else
                                            <div class="input-group col-sm-8 offset-sm-2 mt-1">
                                                <input type="text" name="phone[]" class="form-control" value="{{$row}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="btn btn-danger" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div id="address-input" class="row form-group">
                                        <label for="infoAddress" class="col-sm-2">收貨地址</label>
                                        @foreach(json_decode($tb_Members->info)->address  as $idx => $row)
                                            @if($idx == 0)
                                            <div class="input-group col-sm-8">
                                                <input type="text" name="address[]" class="form-control" value="{{$row}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="btn btn-success" onclick="increase_input('address','text');"><i class="fa fa-plus"></i></span>
                                                </div>
                                            </div>
                                            @else
                                            <div class="input-group col-sm-8 offset-sm-2 mt-1">
                                                <input type="text" name="address[]" class="form-control" value="{{$row}}" readonly>
                                                <div class="input-group-append">
                                                    <span class="btn btn-danger" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{url('/members/edit/'.$tb_Members->id)}}" class="btn btn-secondary">取消修改</a>
                                <button type="submit" class="btn btn-primary">更新</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/members') }}" class="btn btn-secondary">
                        <i class="fa fa-reply mr-1"></i>返回會員列表
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<form action='{{url('/members/edit/'.$tb_Members->id)}}' id="resetForm" class="d-none" method="POST">
    {{ csrf_field() }}
    {{ method_field('patch') }}
</form>
@endsection
@section('js')
<script>
    function reset_confirm(param,value = null) {
        var text = null;
        switch(param){
            case 'nameReset':
                text = '確認重設此會員的名稱 ?';
                $("#resetForm").append('<input type="checkbox" name="name" checked>');
                break;
            case 'passwordReset':
                text = '確認重設此會員的密碼 ?'
                $("#resetForm").append('<input type="checkbox" name="password" checked>');
                break;
            case 'adminReset':
                text = '確認變更此會員的階級 ?'
                $("#resetForm").append('<input type="hidden" name="admin" value='+value.toString()+'>');
                break;
            case 'premissionReset':
                text = '確認變更此會員的權限 ?'
                $("#resetForm").append('<input type="hidden" name="premission" value='+value.toString()+'>');
                break;
            case 'avatorReset':
                text = '確認重設此會員的頭像 ?'
                $("#resetForm").append('<input type="checkbox" name="avator" checked>');
                break;
        }
        var callback = confirm(text);
        if(callback == true){
            $('#resetForm').submit();
        }else{
            $('input[name="name"]').remove();
            $('input[name="password"]').remove();
            $('input[name="avator"]').remove();
            $('input[name="admin"]').remove();
            $('input[name="premission"]').remove();
            $('#admin').val({{$tb_Members->admin}});
            $('#premission').val({{$tb_Members->premission}});
        }
    }
    function increase_input(name,type) {
        if($('#'+name+'-input .input-group').length < 5){
            $('#'+name+'-input').append('<div id="'+name+'-input-increase" class="input-group col-sm-8 offset-sm-2 mt-1"><input type="'+type+'" name="'+name+'[]" class="form-control"><div class="input-group-append"><span class="btn btn-danger" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span></div>');
        }
    }
    function decrease_input() {
        $(this).parent().parent().remove();
    }
</script>
@endsection