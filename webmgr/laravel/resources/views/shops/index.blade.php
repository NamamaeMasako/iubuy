@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-shopping-bag mr-1"></i>商家中心</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item active">商家中心</li>
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
                    <h3 class="card-title">搜尋商家</h3>
                </div>
                <form action="{{url('/shops/search')}}" method="get" class="form-horizontal" role="form">
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="created_at" class="col-sm-1">建立時間</label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" name="created_at" id="reservation" value="{{isset($arr_search['created_at'])?implode(" ~ ",$arr_search['created_at']):''}}"> 
                                </div>
                            </div>
                            <label for="name" class="col-sm-1">商家名稱</label>
                            <div class="col-sm-2">
                                <input type="text" name="name" class="form-control" id="name" value="{{isset($arr_search['name'])?$arr_search['name']:''}}">
                            </div>
                            <label for="ownername" class="col-sm-1">負責人</label>
                            <div class="col-sm-2">
                                <input type="text" name="ownername" class="form-control" id="ownername" value="{{isset($arr_search['ownername'])?$arr_search['ownername']:''}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="premission" class="col-sm-1">商家狀態</label>
                            <div class="col-sm-2">
                                <select name="premission" class="form-control" id="premission">
                                    <option value="" @if(!isset($arr_search['premission'])) selected @endif>--請選擇--</option>
                                    <option value="2" @if(isset($arr_search['premission'])) @if($arr_search['premission'] == 1) selected @endif @endif>營業中</option>
                                    <option value="1" @if(isset($arr_search['premission'])) @if($arr_search['premission'] == 1) selected @endif @endif>休息中</option>
                                    <option value="0" @if(isset($arr_search['premission'])) @if($arr_search['premission'] == 0) selected @endif @endif>禁賣</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{url('/shops/clearsearch')}}" class="btn btn-secondary">清除搜尋條件</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search mr-1"></i>搜尋</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span class="pull-right">
                        共 {{count($tb_Shops)}} 間商家
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>編號</th>
                                <th>商家</th>
                                <th>商標</th>
                                <th>負責人</th>
                                <th>建立時間</th>
                                <th>商家狀態</th>
                                <th>商品列表</th>
                                <th>編輯</th>
                                @if(Auth::user()->admin == 0)
                                <th>刪除</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($tb_Shops as $row)
                                <tr>
                                    <td>
                                        {{ $row->id }}
                                    </td>
                                    <td>
                                        {{ $row->name }}
                                    </td>
                                    <td>
                                        <img src="{{url('upload/shops/'.$row->logo)}}" class="img-circle elevation-2" alt="LOGO" width="50" height="50">
                                    </td>
                                    <td>
                                        {{ $row->Members->name}}
                                        <a href="{{url('members/edit/'.$row->Members)}}"><i class="fa fa-user"></i></a>
                                    </td>
                                    <td>
                                        {{ $row->created_at}}
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text
                                                @if($row->premission == 2)
                                                bg-success
                                                @elseif($row->premission == 0)
                                                bg-danger
                                                @endif">
                                                    @if($row->premission == 2)
                                                    <i class="fa fa-smile-o"></i>
                                                    @elseif($row->premission == 1)
                                                    <i class="fa fa-meh-o"></i>
                                                    @elseif($row->premission == 0)
                                                    <i class="fa fa-frown-o"></i>
                                                    @endif
                                                </span>
                                            </div>
                                            <select class="form-control
                                            @if($row->premission == 2)
                                            text-success
                                            @elseif($row->premission == 0)
                                            text-danger
                                            @endif" onchange="quickEdit('update',{{$row->id}},'premission',this.value)">
                                                <option value="2" class="text-success" @if($row->premission == 2) selected @endif>營業中</option>
                                                <option value="1" class="text-dark" @if($row->premission == 1) selected @endif>休息中</option>
                                                <option value="0" class="text-danger" @if($row->premission == 0) selected @endif>禁賣</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#productList-{{$row->id}}">
                                            <i class="fa fa-file-text"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ url('/shops/edit/'.$row->id) }}" class="btn btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                    </td>
                                    @if(Auth::user()->admin == 0)
                                    <td>
                                        <button class="btn btn-danger" onclick="quickEdit('delete',{{$row->id}});">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    @if($tb_Shops->lastPage() > 1)
                    <ul class="pagination pagination-sm">
                        <li class="page-item">
                            @if($tb_Shops->currentPage() != 1)
                            <a href="{{$tb_Shops->previousPageUrl()}}" class="page-link">&laquo;</a>
                            @endif
                        </li>
                        @for($i = 1;$i <= $tb_Shops->lastPage();$i++)
                        <li class="page-item">
                            @if($tb_Shops->currentPage() == $i)
                            <span class="page-link" style="cursor: default; color: white; background-color: #00c0ef;">{{$i}}</span>
                            @else
                            <a href="{{url('/shops?page='.$i)}}" class="page-link">{{$i}}</a>
                            @endif
                        </li>
                        @endfor
                        <li class="page-item">
                            @if($tb_Shops->hasMorePages())
                            <a href="{{$tb_Shops->nextPageUrl()}}" class="page-link">&raquo;</a>
                            @endif
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@foreach($tb_Shops as $row)
<div class="modal fade" id="productList-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$row->name}}的商品列表</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(count($row->Products)>0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <th>
                                商品編號
                            </th>
                            <th>
                                商品名稱
                            </th>
                            <th>
                                架上狀態
                            </th>
                            <th>
                                編輯
                            </th>
                        </thead>
                        <tbody>
                            @foreach($row->Products as $product)
                            <tr>
                                <td>
                                    {{$product->id}}
                                </td>
                                <td>
                                    {{$product->name}}
                                    @if($product->checked == 0)
                                    <span class="badge badge-danger">{{$product->text_checked}}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-weight-bold
                                        @if($product->onshelf == 0) 
                                        text-danger 
                                        @elseif($product->onshelf == 1) 
                                        text-success
                                        @endif">
                                        {{$product->text_onshelf}}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{url('/products/edit/'.$product->id)}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p>沒有商品可以交易</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
            </div>
        </div>
     </div>
</div>
@endforeach
<form action='' id="quickEditForm" class="d-none" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="">
</form>
@endsection
@section('js')
<script>
    $("#reservation").daterangepicker({
        showDropdowns: true,
        format: "YYYY-MM-DD",
        separator: " ~ ",
        locale: {
            applyLabel: "確定",
            cancelLabel: "清除",
            fromLabel: "開始日期",
            toLabel: "結束日期",
            daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
            monthNames: ["1月", "2月", "3月", "4月", "5月", "6月","7月", "8月", "9月", "10月", "11月", "12月"]
        }
    });
    $("#reservation").on("cancel.daterangepicker", function(ev, picker) {
        $(this).val("");
    });
    function quickEdit(type,shop_id,field = null,origin_value = null){
        if(type == 'update'){
            $("input[name='_method']").val('patch');
            $("#quickEditForm").attr('action','{{url('/shops/edit')}}/'+shop_id);
            $("#quickEditForm").append('<input type="hidden" name="'+field+'" value="'+origin_value.toString()+'">');
            $("#quickEditForm").append('<input type="hidden" name="quick" value="1">');
        }else if(type == 'delete'){
            $("input[name='_method']").val('delete');
            $("#quickEditForm").attr('action','{{url('/shops/delete')}}/'+shop_id);
            var confirm_value = confirm("確認刪除商家?");
            if(confirm_value == false){
                return;
            }
        }
        $("#quickEditForm").submit();
    }
</script>
@endsection