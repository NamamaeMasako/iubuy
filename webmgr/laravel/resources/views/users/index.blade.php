@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-id-card-o mr-1"></i>管理中心<small><i class="fa fa-chevron-right m-1"></i>管理員列表</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">管理中心</li>
                    <li class="breadcrumb-item active"><a href="{{url('/users')}}">管理員列表</a></li>
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
                    <h3 class="card-title">搜尋管理員</h3>
                </div>
                <form action="{{url('/users/search')}}" method="get" class="form-horizontal" role="form">
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
                            <label for="name" class="col-sm-1">管理員名稱</label>
                            <div class="col-sm-2">
                                <input type="text" name="name" class="form-control" id="name" value="{{isset($arr_search['name'])?$arr_search['name']:''}}">
                            </div>
                            <label for="admin" class="col-sm-1">權限等級</label>
                            <div class="col-sm-2">
                                <select name="admin" class="form-control" id="admin">
                                    <option value="" @if(!isset($arr_search['admin'])) selected @endif>--請選擇--</option>
                                    <option value="1" @if(isset($arr_search['admin'])) @if($arr_search['admin'] == 1) selected @endif @endif>一般</option>
                                    <option value="0" @if(isset($arr_search['admin'])) @if($arr_search['admin'] == 0) selected @endif @endif>最高</option>
                                </select>
                            </div>
                            <label for="email" class="col-sm-1">Email</label>
                            <div class="col-sm-2">
                                <input type="text" name="email" class="form-control" id="email" value="{{isset($arr_search['email'])?$arr_search['email']:''}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{url('/users/clearsearch')}}" class="btn btn-secondary">清除搜尋條件</a>
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
                    @if(Auth::user()->admin == 0)
                    <a href="{{ url('/users/create') }}" class="btn btn-sm btn-success">
                         <i class="fa fa-user-plus mr-1"></i>新增管理員
                    </a>
                    @endif
                    <span class="pull-right">
                        共 {{count($tb_Users)}} 位管理者, {{count($count_Users[0])}} 位最高管理員, {{count($count_Users[1])}} 位一般管理員
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>編號</th>
                                <th>管理員</th>
                                <th>頭像</th>
                                <th>權限等級</th>
                                <th>Email</th>
                                <th>建立時間</th>
                                <th>編輯</th>
                                @if(Auth::user()->admin == 0)
                                <th>刪除</th>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($tb_Users as $row)
                                <tr>
                                    <td>
                                        {{ $row->id }}
                                    </td>
                                    <td>
                                        {{ $row->name }}
                                    </td>
                                    <td>
                                        <img src="{{url('upload/users/'.$row->avator)}}" class="img-circle elevation-2" alt="User Image" width="50" height="50" onerror="javascript:this.src='{{url('img/default_avator.jpg')}}'">
                                    </td>
                                    <td>
                                        {{ $row->text_admin }}
                                    </td>
                                    <td>
                                        {{ $row->email}}
                                    </td>
                                    <td>
                                        {{ $row->created_at}}
                                    </td>
                                    @if(Auth::user()->admin == 0 || $row->id == Auth::user()->id)
                                    <td>
                                        <a href="{{ url('/users/edit/'.$row->id) }}" class="btn btn-success">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if(Auth::user()->admin == 0)
                                    <td>
                                        <form action="{{ url('/users/delete/'.$row->id) }}" method="POST" onsubmit="return confirm('確認刪除 ?');">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    @if($tb_Users->lastPage() > 1)
                    <ul class="pagination pagination-sm">
                        <li class="page-item">
                            @if($tb_Users->currentPage() != 1)
                            <a href="{{$tb_Users->previousPageUrl()}}" class="page-link">&laquo;</a>
                            @endif
                        </li>
                        @for($i = 1;$i <= $tb_Users->lastPage();$i++)
                        <li class="page-item">
                            @if($tb_Users->currentPage() == $i)
                            <span class="page-link" style="cursor: default; color: white; background-color: #00c0ef;">{{$i}}</span>
                            @else
                            <a href="{{url('/users?page='.$i)}}" class="page-link">{{$i}}</a>
                            @endif
                        </li>
                        @endfor
                        <li class="page-item">
                            @if($tb_Users->hasMorePages())
                            <a href="{{$tb_Users->nextPageUrl()}}" class="page-link">&raquo;</a>
                            @endif
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
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
</script>
@endsection