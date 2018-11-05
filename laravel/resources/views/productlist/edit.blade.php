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
        <h4 class="card-title text-center">已上架商品列表</h4>
    </div>
    <div class="card-body">
        <table class="table mt-4">
            <tr>
                <th>商品編號</th>
                <th>名稱</th>
                <th>代表圖片</th>
                <th>實際售價</th>
                <th>下架</th>
            </tr>
            @if(count($tb_Productlists)<=0)
            <tr>
                <td>尚未上架任何商品</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @else
                @foreach($tb_Productlists as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->Products->name}}</td>
                    <td>
                        @if(count(json_decode($list->Products->pic))>0)
                        <img src="{{url('webmgr/upload/products/shop_'.$tb_Shop->id.'/'.$list->products_id.'/'.json_decode($list->Products->pic)[0])}}" alt="{{$list->Products->name}}" height="80">
                        @else
                        <img src="{{url('webmgr/upload/products/default_product.jpg')}}" alt="No Img">
                        @endif
                    </td>
                    <td>{{$list->sale_price}}元</td>
                    <td>
                        <button class="btn btn-secondary"><i class="fa fa-level-down"></i></button>
                    </td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header border-bottom border-light">
        <h4 class="card-title text-center">商品列表</h4>
    </div>
    <div class="card-body">
        <table class="table mt-4">
            <tr>
                <th>商品編號</th>
                <th>名稱</th>
                <th>代表圖片</th>
                <th>建議售價</th>
                <th>編輯</th>
                <th>上架</th>
            </tr>
            @if(count($tb_Products)<=0)
            <tr>
                <td>尚未新增任何商品</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @else
                @foreach($tb_Products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>
                        @if(count(json_decode($product->pic))>0)
                        <img src="{{url('webmgr/upload/products/shop_'.$tb_Shop->id.'/'.$product->id.'/'.json_decode($product->pic)[0])}}" alt="{{$product->name}}" height="80">
                        @else
                        <img src="{{url('webmgr/upload/products/default_product.jpg')}}" alt="No Img">
                        @endif
                    </td>
                    <td>{{$product->original_price}}元</td>
                    <td>
                        <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/product/'.$product->id.'/edit')}}" class="btn btn-outline-success"><i class="fa fa-pencil-square-o"></i></a>
                    </td>
                    <td>
                        @if(count($product->Productlists->where('selling',1))>0)
                        已上架
                        @else
                        <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#product-{{$product->id}}"><i class="fa fa-level-up"></i></button>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
@foreach($tb_Products as $product)
<div class="modal fade" id="product-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">上架設定</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/productlist/create')}}" method="post">
                {{csrf_field()}}
                {{method_field('patch')}}
                <input type="text" name="product" class="d-none" value="{{$product->id}}">
                <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-sm-3 col-form-label">商品名稱</label>
                        <div class="input-group col-sm-6">
                            <p class="form-control text-light bg-dark">{{$product->name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="sale_price" class="col-sm-3 col-form-label">實際售價</label>
                        <div class="input-group col-sm-6">
                            <input type="number" name="sale_price" min="0" class="form-control text-light bg-dark" value="{{$product->original_price}}">
                            <div class="input-group-append">
                                <span class="input-group-text bg-dark text-light">元</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">上架</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">關閉</button>
                </div>
            </form>
        </div>
     </div>
</div>
@endforeach
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