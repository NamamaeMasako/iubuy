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
            <a href="{{url('/member/'.$tb_Member->id.'/shop/list')}}" class="list-group-item text-light bg-success"><i class="fa fa-file-text mr-1"></i>擁有商家清單</a>
            @endif
        </div>
    </div>
</div>
@endsection
@section('nine')
<div class="card">
    <div class="card-header border-bottom border-light">
        <h4 class="card-title text-center mt-1">擁有商家清單</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>
                    店名
                </th>
                <th>
                    logo
                </th>
                <th>
                    狀態
                </th>
                <th>
                    管理
                </th>
            </tr>
            @if(count($tb_Shop) > 0)
                @foreach($tb_Shop as $Shop)
                <tr>
                    <td>{{$Shop->name}}</td>
                    <td><img src="{{url('/webmgr/upload/shops/'.$Shop->logo)}}" width="100" alt="Shop Logo"></td>
                    <td>{{$Shop->text_premission}}</td>
                    <td>
                        <a href="{{url('/member/'.$tb_Member->id.'/shop/'.$Shop->id.'/edit')}}" class="btn btn-outline-success"><i class="fa fa-wrench"></i></a>
                    </td>  
                </tr>
                @endforeach
            @else
            <tr>
                <td>尚未擁有商家</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
        </table>
        <div class="col-xl-12 border border-bottom-0 border-left-0 border-right-0 border-light text-right pt-3">
            <a href="{{url('/member/'.$tb_Member->id.'/shop/create')}}" class="btn btn-outline-success"><i class="fa fa-plus mr-1"></i>創立商家</a>
        </div>
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
    function radio_check() {
        $(this).parent().children('label').removeClass('btn-secondary btn-outline-secondary');
        $(this).addClass('btn-secondary');
        $(this).siblings('label').addClass('btn-outline-secondary');
    }
</script>
@endsection