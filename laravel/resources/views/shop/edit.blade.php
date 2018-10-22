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
            <a href="{{url('/member/'.$tb_Member->id.'/shop/'.$tb_Shop->id.'/edit')}}" class="list-group-item bg-success text-light"><i class="fa fa-pencil mr-1"></i>編輯商家資料</a>
            <a href="{{url('/member/'.$tb_Member->id.'/shop/'.$tb_Shop->id.'/productlist/edit')}}" class="list-group-item bg-dark"><i class="fa fa-cubes mr-1"></i>調整架上商品</a>
        </div>
    </div>
</div>
@endsection
@section('nine')
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center mt-1">
                    商家資料
                </h4>
            </div>
            <div class="card-body d-flex justify-content-center">
                <div class="col-12 d-md-flex justify-content-center">
                    <div class="col-md-1"></div>
                    <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/edit')}}" method="post" class="col-md-3 col-6 text-center m-auto pb-4" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <img src="{{url('/webmgr/upload/shops/'.$tb_Shop->logo)}}" class="col-sm-12 rounded-circle" alt="Shop Img">
                        <label for="shopLogo" class="btn btn-success mt-3"><i class="fa fa-upload mr-2"></i>更新Logo</label>
                        <input type="file" class="d-none" name="shopLogo" id="shopLogo" onchange="this.form.submit();">
                    </form>
                    <form action="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/edit')}}" class="col-md-8 col-12" method="post">
                        {{csrf_field()}}
                        {{method_field('patch')}}
                        <div class="row form-group">
                            <label for="nickname" class="col-sm-3 col-form-label">商家名稱</label>
                            <div class="input-group col-sm-9">
                                <input type="text" name="nickname" id="nickname" class="form-control bg-dark text-light" value="{{$tb_Shop->name}}" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="name" class="col-sm-3 col-form-label">出貨人名稱</label>
                            <div class="input-group col-sm-9">
                                <input type="text" name="name" id="name" class="form-control bg-dark text-light" value="{{json_decode($tb_Shop->info)->name }}" required>
                                
                            </div>
                        </div>
                        <div id="email-input" class="row form-group">
                            <label for="email" class="col-sm-3 col-form-label">電子郵件</label>
                            @foreach(json_decode($tb_Shop->info)->email as $idx => $email_row)
                                @if($idx == 0)
                                <div class="input-group col-sm-9">
                                    <input type="email" name="email[]" class="form-control bg-dark text-light" value="{{$email_row}}" required>
                                    <span class="btn btn-outline-success ml-1" onclick="increase_input('email','email');"><i class="fa fa-plus"></i></span>
                                </div>
                                @else
                                <div class="input-group col-sm-9 offset-sm-3 mt-1">
                                    <input type="email" name="email[]" class="form-control bg-dark text-light" value="{{$email_row}}">
                                    <span class="btn btn-outline-danger ml-1" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div id="phone-input" class="row form-group">
                            <label for="phone" class="col-sm-3 col-form-label">連絡電話</label>
                            @if(isset(json_decode($tb_Shop->info)->phone))
                                @foreach(json_decode($tb_Shop->info)->phone as $idx => $phone_row)
                                    @if($idx == 0)
                                    <div class="input-group col-sm-9">
                                        <input type="text" name="phone[]" class="form-control bg-dark text-light" value="{{$phone_row}}">
                                        <span class="btn btn-outline-success ml-1" onclick="increase_input('phone','text');"><i class="fa fa-plus"></i></span>
                                    </div>
                                    @else
                                    <div class="input-group col-sm-9 offset-sm-3 mt-1">
                                        <input type="text" name="phone[]" class="form-control bg-dark text-light" value="{{$phone_row}}">
                                        <span class="btn btn-outline-danger ml-1" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="input-group col-sm-9">
                                    <input type="text" name="phone[]" class="form-control bg-dark text-light" value="">
                                    <span class="btn btn-outline-success ml-1" onclick="increase_input('phone','text');"><i class="fa fa-plus"></i></span>
                                </div>
                            @endif
                        </div>
                        <div id="address-input" class="row form-group">
                            <label for="address" class="col-sm-3 col-form-label">出貨地址</label>
                            @if(isset(json_decode($tb_Shop->info)->address))
                                @foreach(json_decode($tb_Shop->info)->address as $idx => $address_row)
                                    @if($idx == 0)
                                    <div class="input-group col-sm-9">
                                        <input type="text" name="address[]" class="form-control bg-dark text-light" value="{{$address_row}}">
                                        <span class="btn btn-outline-success ml-1" onclick="increase_input('address','text');"><i class="fa fa-plus"></i></span>
                                    </div>
                                    @else
                                    <div class="input-group col-sm-9 offset-sm-3 mt-1">
                                        <input type="text" name="address[]" class="form-control bg-dark text-light" value="{{$address_row}}">
                                        <span class="btn btn-outline-danger ml-1" onclick="decrease_input.call(this);"><i class="fa fa-minus"></i></span>
                                    </div>
                                    @endif
                                @endforeach
                            @else
                            <div class="input-group col-sm-9">
                                <input type="text" name="address[]" class="form-control bg-dark text-light">
                                <span class="btn btn-outline-success ml-1" onclick="increase_input('address','text');"><i class="fa fa-plus"></i></span>
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-9 offset-sm-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success"><i class="fa fa-rotate-right mr-2"></i>更新資料</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center">已上架商品列表</h4>
            </div>
            <div class="card-body">
                @if($tb_Shop->premission == 1)
                <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/productlist/edit')}}" class="btn btn-outline-success"><i class="fa fa-tag mr-1"></i>商品調整</a>
                @else
                <span class="badge badge-danger"><i class="fa fa-warning mr-1"></i>商店資格審核中,還不能上架商品</span>
                @endif
                <table class="table mt-4">
                    <tr>
                        <th>商品編號</th>
                        <th>名稱</th>
                        <th>代表圖片</th>
                        <th>實際售價</th>
                        <th>編輯</th>
                    </tr>
                    @if(count($tb_Shop->Product_lists)<=0)
                    <tr>
                        <td>尚未上架任何商品</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @else
                        @foreach($tb_ProductLists as $list)
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
                            <td>{{$list->sale_price}}</td>
                            <td>
                                <a href="{{url('/member/'.Auth::user()->id.'/shop/'.$tb_Shop->id.'/product/'.$list->products_id.'/edit')}}" class="btn btn-sm btn-outline-success"><i class="fa fa-pencil-square-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
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
</script>
@endsection