@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-gift mr-1"></i>商品中心<small><i class="fa fa-chevron-right m-1"></i>編輯商品</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/products')}}">商品中心</a></li>
                    <li class="breadcrumb-item active">編輯商品</li>
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
                <form action="{{url('/products/edit/'.$tb_Products->id)}}" method="post">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="card-body d-flex align-items-start">
                        <div class="col-sm-6 d-inline-block">
                            <div class="row form-group">
                                <label for="Name" class="col-sm-2">商品名稱</label>
                                <div class="input-group col-sm-6">
                                    <input type="text" id="Name" name="name" class="form-control" value="{{ $tb_Products->name }}" @if(Auth::user()->admin != 0) disabled @endif>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="email" class="col-sm-2">上傳店家</label>
                                <div class="col-sm-6">
                                    <input type="email" id="email" class="form-control" value="{{ $tb_Products->Shops->name }}" disabled>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="intro" class="col-sm-2">商品介紹</label>
                                <div class="col-sm-6">
                                    <input type="text" id="intro" name="intro" class="form-control" value="{{ $tb_Products->intro }}" @if(Auth::user()->admin != 0) disabled @endif>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="original_price" class="col-sm-2">預設價格</label>
                                <div class="col-sm-6">
                                    <input type="number" id="original_price" class="form-control" value="{{ $tb_Products->original_price }}" disabled>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="checked" class="col-sm-2">可否販售</label>
                                <div class="col-sm-6">
                                    <select id="checked" name="checked" class="form-control">
                                        <option value="0" @if($tb_Products->checked == 0) selected @endif>可</option>
                                        <option value="1" @if($tb_Products->checked == 1) selected @endif>不可</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 d-inline-block">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        商品照片
                                    </h4>
                                </div>
                                <div class="card-body d-flex justify-content-left flex-wrap">
                                    @foreach(json_decode($tb_Products->pic) as $idx => $pic)
                                    <div class="card col-4 text-center">
                                        <img src="{{url('/upload/products/shop_'.$tb_Products->shops_id.'/'.$tb_Products->id.'/'.$pic)}}" class="card-img-top" alt="Product Img" style="height: 185px;">
                                        <div class="card-body">
                                            @if(count(json_decode($tb_Products->pic)) == 1)
                                            <span class="btn btn-sm btn-warning" onclick="check.call(this,'pic_{{$idx+1}}');">
                                                <i class="fa fa-square-o mr-1"></i>重設
                                            </span>
                                            @else
                                            <span class="btn btn-sm btn-danger" onclick="check.call(this,'pic_{{$idx+1}}');">
                                                <i class="fa fa-square-o mr-1"></i>刪除
                                            </span>
                                            @endif
                                        </div>
                                        <input type="checkbox" id="pic_{{$idx+1}}" name="pic[]" class="d-none" value="{{$pic}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/products') }}" class="btn btn-secondary">
                            <i class="fa fa-reply mr-1"></i>返回商品列表
                        </a>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<form action='{{url('/products/edit/'.$tb_Products->id)}}' id="resetForm" class="d-none" method="POST">
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
                text = '確認重設此商品的名稱 ?';
                $("#resetForm").append('<input type="checkbox" name="name" checked>');
                break;
            case 'checkedReset':
                text = '確認變更此商品的審核狀態 ?'
                $("#resetForm").append('<input type="hidden" name="checked" value='+value.toString()+'>');
                break;
            case 'avatorReset':
                text = '確認重設此商品的Logo ?'
                $("#resetForm").append('<input type="checkbox" name="logo" checked>');
                break;
        }
        var callback = confirm(text);
        if(callback == true){
            $('#resetForm').submit();
        }else{
            $('input[name="name"]').remove();
            $('input[name="logo"]').remove();
            $('input[name="checked"]').remove();
            $('#premission').val({{$tb_Products->premission}});
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
    function check(id) {
        var value = $('#'+id).prop("checked");
        if(value === false){
            $('#'+id).attr("checked",true);
            $(this).children('.fa').removeClass('fa-square-o');
            $(this).children('.fa').addClass('fa-check-square-o');
        }else{
            $('#'+id).attr("checked",false);
            $(this).children('.fa').removeClass('fa-check-square-o');
            $(this).children('.fa').addClass('fa-square-o');
        }
    }
</script>
@endsection