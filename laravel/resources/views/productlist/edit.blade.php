@extends('layouts.content.three-nine')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('three')
<div class="card">
    <div class="card-header">
        <div class="col-xl-12 mb-3">
            <img src="{{url('/webmgr/upload/members/'.$tb_Member->avator)}}" class="col-xl-4 rounded-circle p-0" alt="Member Img">
            <span class="pl-1">{{$tb_Member->name}}</span>
            <span class="badge @if($tb_Member->admin != 0) badge-warning @else badge-secondary @endif">{{$tb_Member->text_admin}}會員</span>
        </div>
        <div class="col-xl-12">
            <a href="{{url('/member/'.$tb_Member->id)}}" class="btn btn-outline-success">
                <i class="fa fa-arrow-left mr-1"></i>返回個人頁面
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="{{url('/member/'.$tb_Member->id.'/edit')}}" class="list-group-item bg-dark"><i class="fa fa-pencil mr-1"></i>編輯個人資料</a>
            @if($tb_Member->admin != 0)
            <a href="{{url('/member/'.$tb_Member->id.'/shop/list')}}" class="list-group-item bg-dark"><i class="fa fa-file-text mr-1"></i>擁有商家清單</a>
            @endif
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <div class="col-xl-12 mb-3">
            <img src="{{url('/webmgr/upload/shops/'.$tb_Shop->logo)}}" class="col-xl-4 rounded-circle p-0" alt="Shop Img">
            <span class="pl-1">{{$tb_Shop->name}}</span>
        </div>
        <div class="col-xl-12">
            <a href="{{url('/shop/'.$tb_Shop->id)}}" class="btn btn-outline-success">
                <i class="fa fa-arrow-left mr-1"></i>返回商家頁面
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="{{url('/member/'.$tb_Member->id.'/shop/'.$tb_Shop->id.'/edit')}}" class="list-group-item bg-dark"><i class="fa fa-pencil mr-1"></i>編輯商家資料</a>
            <a href="{{url('/member/'.$tb_Member->id.'/shop/'.$tb_Shop->id.'/productlist/edit')}}" class="list-group-item bg-success text-light"><i class="fa fa-cubes mr-1"></i>調整架上商品</a>
        </div>
    </div>
</div>
@endsection
@section('nine')
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center mt-1">
                    {{$tb_Shop->name}}的商品
                </h4>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div class="col-12 d-md-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header border-bottom border-light">
                                <h4 class="card-title text-center mt-1">已上架</h4>
                            </div>
                            <div class="card-body">
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="col-3">商品</div>
                                    <div class="col-3">原價</div>
                                    <div class="col-3">售價</div>
                                    <div class="col-3">下架</div>
                                </div>
                                <div class="col-12 border border-light rounded p-2">
                                    @if(count($tb_ProductList)<=0)
                                    尚未上架任何商品
                                    @else
                                        @foreach($tb_ProductList as $idx => $list)
                                        <div class="col-12 d-flex justify-content-center p-0 mb-2">
                                            <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/product/'.$list->products_id.'/edit')}}" class="col-3 btn btn-block btn-sm btn-dark">{{$list->Products->name}}</a>
                                            <div class="col-3">{{$list->Products->original_price}}</div>
                                            <div class="col-3">{{$list->sale_price}}</div>
                                            <div class="col-3">
                                                <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/productlist/'.$list->id.'/update')}}" method="post">
                                                    {{csrf_field()}}
                                                    {{method_field('patch')}}
                                                    <input type="text" name="product" value="{{$list->products_id}}" class="d-none">
                                                    <button class="btn btn-sm btn-dark"><i class="fa fa-level-down"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header border-bottom border-light">
                                <h4 class="card-title text-center mt-1">未上架</h4>
                            </div>
                            <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/productlist/create')}}" method="post">
                                {{csrf_field()}}
                                {{method_field('patch')}}
                                <div class="card-body">
                                    <div class="col-12 d-flex justify-content-center">
                                        <div class="col-3">商品</div>
                                        <div class="col-3">原價</div>
                                        <div class="col-3">售價</div>
                                        <div class="col-3">選取</div>
                                    </div>
                                    <div class="col-12 border border-light rounded p-2">
                                    @if(count($tb_Product)<=0)
                                    沒有商品可以上架
                                    @else
                                        @foreach($tb_Product as $idx => $product)
                                        <div class="col-12 d-flex justify-content-center p-0 mb-2">
                                            <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/product/'.$product->id.'/edit')}}" class="col-3 btn btn-block btn-sm btn-dark">{{$product->name}}</a>
                                            @if($product->checked == 0)
                                            <div class="col-3" id="o-price_{{$idx}}">{{$product->original_price}}</div>
                                            <div class="col-3">
                                                <div class="input-group d-none" id="priceEnter_{{$idx}}">
                                                    <input type="number" id="price_{{$idx}}" name="sale_price[]" class="form-control form-control-sm bg-dark text-light" placeholder="輸入售價" disabled>
                                                    <div class="input-group-append">
                                                        <span class="btn btn-sm btn-outline-warning ml-1" onclick="auto_input($('#o-price_{{$idx}}').text(),'price_{{$idx}}');">同原價</span>
                                                    </div>
                                                </div>
                                                <div class="input-group" id="priceDisabled_{{$idx}}"></div>
                                            </div>
                                            <div class="col-3">
                                                <label for="product_{{$idx}}" class="btn btn-sm btn-dark m-0" onclick="picProduct.call(this,'{{$idx}}');">
                                                    <i class="fa fa-square-o"></i>
                                                </label>
                                                <input type="checkbox" id="product_{{$idx}}" class="d-none">
                                                <input type="text" class="d-none" id="pid_{{$idx}}"  name="product[]" value="{{$product->id}}" disabled>
                                            </div>
                                            @else
                                            <div class="col-9 d-flex justify-content-center align-items-center">
                                                <span class="badge badge-danger"><i class="fa fa-frown-o mr-1"></i>此商品已被系統屏蔽</span>
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    @endif
                                    </div>                  
                                </div>
                                <div class="card-footer d-flex justify-content-between text-right">
                                    @if (count($errors) > 0)
                                    <div class="alert alert-dark">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif   
                                    <div class="col-6 p-0">
                                        <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/product/create')}}" class="btn  btn-outline-success pull-left">
                                            <i class="fa fa-plus mr-1"></i>新增商品
                                        </a> 
                                    </div>
                                    <div class="col-6 ">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-cubes mr-1"></i>上架</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection
@section('js')
<script>
    function auto_input(value,name) {
        console.log(value);
        $("#"+name).val(value);
    }
    function picProduct(value){
        var check = $('#product_'+value).prop("checked");
        if(check === true){
            $('#product_'+value).attr("checked",false);
            $(this).children('.fa').removeClass('fa-check-square-o');
            $(this).children('.fa').addClass('fa-square-o');
            $('#priceEnter_'+value).addClass('d-none');
            $('#priceDisabled_'+value).removeClass('d-none');
            $('#price_'+value).prop("disabled",true);
            $('#pid_'+value).prop("disabled",true);
        }else{
            $('#product_'+value).attr("checked",true);
            $(this).children('.fa').removeClass('fa-square-o');
            $(this).children('.fa').addClass('fa-check-square-o');
            $('#priceDisabled_'+value).addClass('d-none');
            $('#priceEnter_'+value).removeClass('d-none');
            $('#price_'+value).prop("disabled",false);
            $('#pid_'+value).prop("disabled",false);
        }
    }
</script>
@endsection