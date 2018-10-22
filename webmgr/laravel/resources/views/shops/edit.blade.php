@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-bag mr-1"></i>商家中心<small><i class="fa fa-chevron-right m-1"></i>編輯商家</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/shops')}}">商家中心</a></li>
                    <li class="breadcrumb-item active">編輯商家</li>
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
                            <label for="Name" class="col-sm-2">商家名稱</label>
                            <div class="input-group col-sm-6">
                                <input type="text" id="Name" class="form-control" value="{{ $tb_Shops->name }}" disabled>
                                <span class="input-group-append">
                                    <span class="btn btn-warning" onclick="reset_confirm('nameReset');">重設</span>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="email" class="col-sm-2">負責人</label>
                            <div class="col-sm-6">
                                <input type="email" id="email" class="form-control" value="{{ $tb_Shops->Members->name }}" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="premission" class="col-sm-2">權限</label>
                            <div class="col-sm-6">
                                <select id="premission" class="form-control" onchange="reset_confirm('premissionReset',this.value);">
                                    <option value="1" @if($tb_Shops->premission == 1) selected @endif>開放</option>
                                    <option value="0" @if($tb_Shops->premission == 0) selected @endif>停權</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2">商家Logo</label>
                            <div class="col-sm-6"> 
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title"><small>目前Logo</small></h4>
                                                <div class="card-tools">
                                                    <span class="btn btn-sm btn-warning mb-1" onclick="reset_confirm('avatorReset');">重設</span>
                                                </div>
                                            </div>
                                            <div class="card-body text-center">
                                                <img src="{{url('upload/Shops/'.$tb_Shops->logo)}}" class="col-sm-12 img-circle elevation-2" alt="Shop Image">
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{url('/shops/edit/'.$tb_Shops->id)}}" class="col-sm-5 d-inline-block" method="post">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="card card-info">
                            <div class="card-header">
                                <h4 class="card-title">出貨資訊</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="row form-group">
                                        <label for="infoName" class="col-sm-2">出貨人名稱</label>
                                        <div class="input-group col-sm-5">
                                            <input type="text" class="form-control" id="infoName" name="info_name" value="{{json_decode($tb_Shops->info)->name}}" required>
                                        </div>
                                    </div>
                                    <div id="email-input" class="row form-group">
                                        <label for="infoEmail" class="col-sm-2">電子郵件</label>
                                        @foreach(json_decode($tb_Shops->info)->email  as $idx => $row)
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
                                        @foreach(json_decode($tb_Shops->info)->phone  as $idx => $row)
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
                                        @foreach(json_decode($tb_Shops->info)->address  as $idx => $row)
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
                                <a href="{{url('/Shops/edit/'.$tb_Shops->id)}}" class="btn btn-secondary">取消修改</a>
                                <button type="submit" class="btn btn-primary">更新</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/shops') }}" class="btn btn-secondary">
                        <i class="fa fa-reply mr-1"></i>返回商家列表
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<form action='{{url('/shops/edit/'.$tb_Shops->id)}}' id="resetForm" class="d-none" method="POST">
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
                text = '確認重設此商家的名稱 ?';
                $("#resetForm").append('<input type="checkbox" name="name" checked>');
                break;
            case 'premissionReset':
                text = '確認變更此商家的權限 ?'
                $("#resetForm").append('<input type="hidden" name="premission" value='+value.toString()+'>');
                break;
            case 'avatorReset':
                text = '確認重設此商家的Logo ?'
                $("#resetForm").append('<input type="checkbox" name="logo" checked>');
                break;
        }
        var callback = confirm(text);
        if(callback == true){
            $('#resetForm').submit();
        }else{
            $('input[name="name"]').remove();
            $('input[name="logo"]').remove();
            $('input[name="premission"]').remove();
            $('#premission').val({{$tb_Shops->premission}});
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