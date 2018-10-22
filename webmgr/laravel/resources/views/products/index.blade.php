@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-gift mr-1"></i>商品中心</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item active">商品中心</li>
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
                    <h3 class="card-title">搜尋商品</h3>
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
                            <label for="name" class="col-sm-1">商品名稱</label>
                            <div class="col-sm-2">
                                <input type="text" name="name" class="form-control" id="name" value="{{isset($arr_search['name'])?$arr_search['name']:''}}">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="premission" class="col-sm-1">權限</label>
                            <div class="col-sm-2">
                                <select name="premission" class="form-control" id="premission">
                                    <option value="" @if(!isset($arr_search['premission'])) selected @endif>--請選擇--</option>
                                    <option value="1" @if(isset($arr_search['premission'])) @if($arr_search['premission'] == 1) selected @endif @endif>開放</option>
                                    <option value="0" @if(isset($arr_search['premission'])) @if($arr_search['premission'] == 0) selected @endif @endif>停權</option>
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
                        共 {{count($tb_Products)}} 間商品
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>編號</th>
                                <th>商品</th>
                                <th>上傳商家</th>
                                <th>建立時間</th>
                                <th>可否販售</th>
                                <th>編輯</th>
                                @if(Auth::user()->admin == 0)
                                <th>刪除</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($tb_Products as $row)
                                <tr>
                                    <td>
                                        {{ $row->id }}
                                    </td>
                                    <td>
                                        {{ $row->name }}
                                    </td>
                                    <td>
                                        {{ $row->Shops->name}}
                                        <a href="{{url('shops/edit/'.$row->Shops->id)}}"><i class="fa fa-fort-awesome"></i></a>
                                    </td>
                                    <td>
                                        {{ $row->created_at}}
                                    </td>
                                    <td>
                                        {{ $row->text_checked}}
                                    </td>
                                    <td>
                                        <a href="{{ url('/products/edit/'.$row->id) }}" class="btn btn-success">
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
                    @if($tb_Products->lastPage() > 1)
                    <ul class="pagination pagination-sm">
                        <li class="page-item">
                            @if($tb_Products->currentPage() != 1)
                            <a href="{{$tb_Products->previousPageUrl()}}" class="page-link">&laquo;</a>
                            @endif
                        </li>
                        @for($i = 1;$i <= $tb_Products->lastPage();$i++)
                        <li class="page-item">
                            @if($tb_Products->currentPage() == $i)
                            <span class="page-link" style="cursor: default; color: white; background-color: #00c0ef;">{{$i}}</span>
                            @else
                            <a href="{{url('/products?page='.$i)}}" class="page-link">{{$i}}</a>
                            @endif
                        </li>
                        @endfor
                        <li class="page-item">
                            @if($tb_Products->hasMorePages())
                            <a href="{{$tb_Products->nextPageUrl()}}" class="page-link">&raquo;</a>
                            @endif
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
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
    function quickEdit(type,id,field = null,origin_value = null){
        if(type == 'update'){
            $("input[name='_method']").val('patch');
            $("#quickEditForm").attr('action','{{url('/products/edit')}}/'+id);
            var value;
            value = origin_value == 1? 0:1;
            $("#quickEditForm").append('<input type="hidden" name="'+field+'" value="'+value.toString()+'">');
            $("#quickEditForm").append('<input type="hidden" name="quick" value="1">');
        }else if(type == 'delete'){
            $("input[name='_method']").val('delete');
            $("#quickEditForm").attr('action','{{url('/products/delete')}}/'+id);
            var confirm_value = confirm("確認刪除商品?");
            if(confirm_value == false){
                return;
            }
        }
        $("#quickEditForm").submit();
    }
</script>
@endsection