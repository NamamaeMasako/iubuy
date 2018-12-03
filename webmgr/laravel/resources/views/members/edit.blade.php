@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="nav-icon fa fa-users mr-1"></i>會員中心
                    <small>
                        <i class="fa fa-chevron-right m-1"></i>會員列表
                        <i class="fa fa-chevron-right m-1"></i>編輯會員
                    </small>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">會員中心</li>
                    <li class="breadcrumb-item"><a href="{{url('/members')}}">會員列表</a></li>
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
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="#tab-1" class="nav-link @if(empty(\Session::get("tab"))) active @endif" data-toggle="tab">帳號資訊</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-2" class="nav-link @if(!empty(\Session::get("tab"))) active @endif" data-toggle="tab">個人資訊</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body d-flex align-items-start">
                    <div class="tab-content col-sm-12">
                        <div class="tab-pane @if(empty(\Session::get("tab"))) active @endif" id="tab-1">
                            <div class="d-flex">
                                <div class="col-sm-6">
                                    <div class="row form-group">
                                        <label for="Account" class="col-sm-3">帳號</label>
                                        <div class="input-group col-sm-7">
                                            <input type="text" id="Account" class="form-control" value="{{ $tb_Member->account }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="Name" class="col-sm-3">暱稱</label>
                                        <div class="input-group col-sm-7">
                                            <input type="text" id="Name" class="form-control" value="{{ $tb_Member->name }}" disabled>
                                            <span class="input-group-append">
                                                <span class="btn btn-warning" onclick="reset_confirm('nameReset');">重設</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="email" class="col-sm-3">已綁定電子郵件</label>
                                        <div class="col-sm-7">
                                            <input type="email" id="email" class="form-control" value="{{ $tb_Member->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="phone" class="col-sm-3">已綁定手機</label>
                                        <div class="col-sm-7">
                                            <input type="text" id="phone" class="form-control" value="{{ $tb_Member->phone }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div id="accordion" class="col-sm-7 offset-sm-3">
                                            <span class="btn btn-warning" onclick="reset_confirm('passwordReset');">重設密碼</span>
                                        </div>
                                    </div>
                                    @if(Auth::user()->admin == 0)
                                    <div class="row form-group">
                                        <label for="admin" class="col-sm-3">階級</label>
                                        <div class="col-sm-7">
                                            <select id="admin" class="form-control" onchange="reset_confirm('adminReset',this.value);">
                                                <option value="0" @if($tb_Member->admin == 0) selected @endif>一般</option>
                                                <option value="1" @if($tb_Member->admin == 1) selected @endif>高級</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row form-group">
                                        <label for="premission" class="col-sm-3">權限</label>
                                        <div class="col-sm-7">
                                            <select id="premission" class="form-control" onchange="reset_confirm('premissionReset',this.value);">
                                                <option value="1" @if($tb_Member->premission == 1) selected @endif>開放</option>
                                                <option value="0" @if($tb_Member->premission == 0) selected @endif>停權</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row form-group">
                                        <div class="col-sm-6"> 
                                            <div class="row">
                                                <div class="card card-info">
                                                    <div class="card-header">
                                                        <h4 class="card-title"><small>目前頭像</small></h4>
                                                        <div class="card-tools">
                                                            <span class="btn btn-sm btn-warning mb-1" onclick="reset_confirm('avatorReset');">重設</span>
                                                        </div>
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <img src="{{url('upload/members/'.$tb_MemberProfile->avator)}}" class="col-sm-12 img-circle elevation-2" alt="User Image" onerror="javascript:this.src='{{url('img/default_avator.jpg')}}'">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane @if(!empty(\Session::get("tab"))) active @endif" id="tab-2">
                            <form action="{{url('/members/edit/'.$tb_Member->account)}}" class="col-sm-6 d-inline-block" method="post">
                                {{csrf_field()}}
                                {{method_field('patch')}}
                                <input type="hidden" name="tab" value="2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-sm-12">
                                            <div class="row form-group">
                                                <label for="infoName" class="col-sm-2">真實姓名</label>
                                                <div class="input-group col-sm-8">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            姓
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="infoName" name="real_last_name" value="{{$tb_MemberProfile->real_last_name}}" required>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            名
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="infoName" name="real_first_name" value="{{$tb_MemberProfile->real_first_name}}" required>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="gender" class="col-sm-2">性別</label>
                                                <div class="input-group col-sm-4">
                                                    <label for="male" class="pr-3">
                                                        <input type="radio" id="male" name="gender" class="flat-red" value="male" 
                                                        @if($tb_MemberProfile->gender == 'male') checked @endif>
                                                        男
                                                    </label>
                                                    <label for="female" class="pr-3">
                                                        <input type="radio" id="female" name="gender" class="flat-red" value="female"
                                                        @if($tb_MemberProfile->gender == 'female') checked @endif>
                                                        女
                                                    </label>
                                                    <label for="other">
                                                        <input type="radio" id="female" name="gender" class="flat-red" value="other"
                                                        @if($tb_MemberProfile->gender == 'other') checked @endif>
                                                        其他
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="email-input" class="row form-group">
                                                <label for="infoEmail" class="col-sm-2">備援電子郵件</label>
                                                @if(!empty($tb_MemberProfile->spare_email))
                                                    @foreach(json_decode($tb_MemberProfile->spare_email)  as $idx => $row)
                                                        @if($idx == 0)
                                                        <div class="input-group col-sm-8">
                                                            <input type="email" name="spare_email[]" class="form-control" value="{{$row}}">
                                                            <div class="input-group-append">
                                                                <span class="btn btn-success" onclick="increase_input('spare_email','email');"><i class="fa fa-plus"></i></span>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="input-group col-sm-8 offset-sm-2 mt-1">
                                                            <input type="text" name="spare_email[]" class="form-control" value="{{$row}}" readonly>
                                                            <div class="input-group-append">
                                                                <span class="btn btn-danger" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                <div class="input-group col-sm-8">
                                                    <input type="email" name="spare_email[]" class="form-control" value="">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-success" onclick="increase_input('spare_email','email');"><i class="fa fa-plus"></i></span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div id="phone-input" class="row form-group">
                                                <label for="infoPhone" class="col-sm-2">備援電話</label>
                                                @if(!empty($tb_MemberProfile->spare_phone))
                                                    @foreach(json_decode($tb_MemberProfile->spare_phone)  as $idx => $row)
                                                        @if($idx == 0)
                                                        <div class="input-group col-sm-8">
                                                            <input type="text" name="spare_phone[]" class="form-control" value="{{$row}}">
                                                            <div class="input-group-append">
                                                                <span class="btn btn-success" onclick="increase_input('spare_phone','text');"><i class="fa fa-plus"></i></span>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="input-group col-sm-8 offset-sm-2 mt-1">
                                                            <input type="text" name="spare_phone[]" class="form-control" value="{{$row}}" readonly>
                                                            <div class="input-group-append">
                                                                <span class="btn btn-danger" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                <div class="input-group col-sm-8">
                                                    <input type="text" name="spare_phone[]" class="form-control" value="">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-success" onclick="increase_input('spare_phone','text');"><i class="fa fa-plus"></i></span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <div id="address-input" class="row form-group">
                                                <label for="infoAddress" class="col-sm-2">地址</label>
                                                @if(!empty($tb_MemberProfile->address))
                                                    @foreach(json_decode($tb_MemberProfile->address)  as $idx => $row)
                                                        @if($idx == 0)
                                                        <div class="input-group col-sm-8">
                                                            <input type="text" name="address[]" class="form-control" value="{{$row}}">
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
                                                @else
                                                <div class="input-group col-sm-8">
                                                    <input type="text" name="address[]" class="form-control" value="">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-success" onclick="increase_input('address','text');"><i class="fa fa-plus"></i></span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{url('/members/edit/'.$tb_Member->account.'#tab-2')}}" class="btn btn-secondary">取消修改</a>
                                        <button type="submit" class="btn btn-primary">更新</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
<form action='{{url('/members/edit/'.$tb_Member->account)}}' id="resetForm" class="d-none" method="POST">
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
            $('#admin').val({{$tb_Member->admin}});
            $('#premission').val({{$tb_Member->premission}});
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