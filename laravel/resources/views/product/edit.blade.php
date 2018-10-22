@extends('layouts.master')
@section('css')
<link href="{{url('css/member.css')}}" rel="stylesheet">
@endsection
@section('content')
<section class="d-flex align-items-center justify-content-center">
    <div class="col-xl-8"> 
        <div class="card">
            <div class="card-header d-flex border-bottom border-light">
                <div class="col-md-2">
                    <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Product->shops_id.'/productlist/edit')}}" class="btn btn-outline-success pull-left">
                        <i class="fa fa-arrow-left mr-1"></i>商品上架列表
                    </a>
                </div>
                <h4 class="card-title col-md-8 text-center mt-1">
                    商品編輯
                </h4>
            </div>
            <div class="card-body d-md-flex justify-content-center">
                <div class="col-md-4 col-sm-12">
                    <h4 class="text-center mb-0">商品資訊</h4>
                    <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Product->shops_id.'/product/'.$tb_Product->id.'/edit')}}" method="post" class="border rounded p-4">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="row form-group">
                            <label for="name" class="col-md-4 col-form-label">商品名稱</label>
                            <div class="input-group col-md-8">
                                <input type="text" id="name" name="name" class="form-control bg-dark text-light" value="{{$tb_Product->name}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="p_intro" class="col-md-4 col-form-label">商品介紹</label>
                            <div class="input-group col-md-8">
                                <input type="text" id="p_intro" name="intro" class="form-control bg-dark text-light" value="{{$tb_Product->intro}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="original_price" class="col-md-4 col-form-label">商品定價</label>
                            <div class="input-group col-md-8">
                                <span class="pt-2 mr-2">新台幣</span>
                                <input type="number" id="original_price" name="original_price" class="form-control bg-dark text-light" value="{{$tb_Product->original_price}}">
                                <span class="pt-2 ml-2">元</span>
                            </div>
                        </div>
                        <div class="text-right" style="border-top: 1px solid #fff;">
                            <button class="btn btn-success mt-2"><i class="fa fa-file-text-o mr-1"></i>提交</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 col-sm-12">
                    <h4 class="text-center mb-0">商品照片及預覽</h4>
                    <div class="border rounded p-4">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators"></ol>
                            <div class="carousel-inner">
                                @if(count(json_decode($tb_Product->pic))>0)
                                    @foreach(json_decode($tb_Product->pic) as $id_pic => $pic)
                                    <div class="carousel-item @if($id_pic == 0) active @endif" style="height: 250px;overflow: hidden;">
                                        <img class="d-block m-auto h-100" src="{{url('webmgr/upload/products/shop_'.$tb_Product->shops_id.'/'.$tb_Product->id.'/'.$pic)}}" alt="{{$pic}}">
                                    </div>
                                    @endforeach
                                @else
                                    <div class="carousel-item active" style="height: 250px;overflow: hidden;">
                                        <img class="d-block m-auto h-100" src="{{url('webmgr/upload/products/default_product.jpg')}}" alt="No Img">
                                    </div>
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <div class="d-flex flex-sm-wrap justify-content-center mt-2">
                            @foreach(json_decode($tb_Product->pic) as $id_pic => $pic)
                            <div class="card col-md-2 col-sm-3 ml-2">
                                <div class="card-header text-center">
                                    <button class="btn btn-sm btn-danger" onclick="picDelete('{{$id_pic+1}}');"><i class="fa fa-times"></i></button>
                                </div>
                                <img class="card-img-top" src="{{url('webmgr/upload/products/shop_'.$tb_Product->shops_id.'/'.$tb_Product->id.'/'.$pic)}}" alt="{{$pic}}" style="height: 90px;">
                                <div class="card-body d-flex justify-content-center">
                                    @if($id_pic != 0)
                                    <button class="btn btn-sm btn-dark mr-1" onclick="pickPic('{{$id_pic+1}}','front');"><i class="fa fa-chevron-left"></i></button>
                                    @endif
                                    <label for="pic" class="btn btn-sm btn-dark m-0" onclick="pickPic('{{$id_pic+1}}');">變更</label>
                                    @if($id_pic != (count(json_decode($tb_Product->pic))-1))
                                    <button class="btn btn-sm btn-dark ml-1" onclick="pickPic('{{$id_pic+1}}','back');"><i class="fa fa-chevron-right"></i></button>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @for($j=0;$j<(5-count(json_decode($tb_Product->pic)));$j++)
                                <label for="pic" class="d-flex justify-content-center col-md-2 col-sm-3 align-items-center btn btn-block btn-dark border border-light ml-2 mt-3 mb-0" onclick="pickPic('{{count(json_decode($tb_Product->pic))+1}}');">
                                    <i class="fa fa-plus mr-1"></i>上傳新圖片
                                </label> 
                            @endfor
                        </div>
                    </div>
                    <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Product->shops_id.'/product/'.$tb_Product->id.'/edit')}}" method="post" enctype="multipart/form-data" class="d-none" id="picForm">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <input type="file" id="pic" name="pic" onchange="$('#picForm').submit();">
                        <input type="text" id="pic_name" name="pic_name">
                        <input type="text" id="way" name="way">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    function increase_input(name,type) {
        if($('#'+name+'-input .input-group').length < 5){
            $('#'+name+'-input').append('<div id="'+name+'-input-increase" class="input-group col-sm-9 offset-sm-3 mt-1"><input type="'+type+'" name="'+name+'[]" class="form-control bg-dark text-light"><button class="btn btn-outline-danger ml-1" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></button></div>');
        }
    }
    function decrease_input() {
        $(this).parent().remove();
    }
    function pickPic(pic_name,way = null) {
        $('#pic_name').val(pic_name);
        if(way){
            $('#way').val(way);
            $('#picForm').submit();
        }
    }
    function picDelete(pic_name) {
        $('#picForm input[name="_method"]').val('delete');
        $('#pic_name').val(pic_name);
        $('#picForm').submit();
    }
</script>
@endsection