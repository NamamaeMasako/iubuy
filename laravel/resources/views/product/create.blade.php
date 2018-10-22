@extends('layouts.master')
@section('css')
<link href="{{url('css/member.css')}}" rel="stylesheet">
@endsection
@section('content')
<section class="d-flex align-items-center justify-content-center pt-5">
    <div class="col-xl-8 pt-5"> 
        <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/productlist/edit')}}" class="btn btn-outline-success mr-1">
            <i class="fa fa-reply mr-2"></i>返回商品上架
        </a>
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center mt-1">新增商品</h4>
            </div>
            <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/product/create')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="card-body d-flex justify-content-center">
                    <div class="col-sm-8">
                        <div class="row form-group">
                            <label for="name" class="col-md-3 col-form-label">商品名稱</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="name" id="name" class="form-control bg-dark text-light" required value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="infomation" class="col-md-3 col-form-label">商品介紹</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="intro" id="infomation" class="form-control bg-dark text-light" required value="{{old('intro')}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="original_price" class="col-md-3 col-form-label">商品定價</label>
                            <div class="input-group col-md-5">
                                <span class="pt-2 mr-2">新台幣</span>
                                <input type="number" name="original_price" id="original_price" class="form-control bg-dark text-light" required value="{{old('original_price')}}">
                                <span class="pt-2 ml-2">元</span>
                            </div>
                        </div>
                        <div id="pic-input" class="row form-group">
                            <label class="col-md-3 col-form-label">商品圖片</label>
                            <div class="input-group col-md-9">
                                <span id="picinfo_1" class="pt-2">未選擇圖片</span>
                                <label class="btn btn-success ml-1">
                                    <i class="fa fa-upload mr-1"></i>選擇圖片
                                    <input type="file" name="pic[]" id="pic_1" class="d-none" onchange="show_fileInfo(1);">
                                </label>
                                <label class="btn btn-outline-success ml-1" onclick="increase_input('pic','file');"><i class="fa fa-plus"></i></label>
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
                    <div class="offset-sm-1 col-sm-6 d-flex justify-content-center">
                        <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-file-text mr-2"></i>申請</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    function show_fileInfo(id) {
        var info = $('#pic_'+id).val();
        var arr = info.split("\\");
        $('#picinfo_'+id).text(arr[(arr.length-1)]);
    }
    function increase_input(name,type) {
        var count = $('#'+name+'-input .input-group').length;
        if(count < 5){
            $('#'+name+'-input').append('<div id="'+name+'-input-increase" class="input-group col-sm-9 offset-sm-3 mt-1"><span id="picinfo_'+(count+1)+'" class="pt-2">未選擇圖片</span><label class="btn btn-success ml-1"><i class="fa fa-upload mr-1"></i>選擇圖片<input type="'+type+'" name="'+name+'[]" id="pic_'+(count+1)+'" class="d-none" onchange="show_fileInfo('+(count+1)+');"></label><label class="btn btn-outline-danger ml-1" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></label></div>');
        }
    }
    function decrease_input() {
        $(this).parent().remove();
    }
</script>
@endsection