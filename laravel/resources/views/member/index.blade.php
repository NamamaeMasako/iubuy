@extends('layouts.content.three-nine')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('three')
    <div class="card">
        <div class="card-header border-bottom border-light">
            <h4 class="card-title text-center mt-1">個人資料</h4>
        </div>
        <div class="card-body text-center">
            <div class="col-sm-8 rounded-circle @if($tb_Member->admin != 0) bg-warning @endif mx-auto mb-3 p-1">
                <img src="{{url('/webmgr/upload/members/'.$tb_Member->avator)}}" class="w-100 rounded-circle" alt="Member Img" onerror="javascript:this.src='{{url('/webmgr/img/default_avator.jpg')}}'">
            </div>
            @if($tb_Member->admin != 0)
            <div class="col-sm-12 h2">
                <span class="w-100 text-center" id="level-star">
                @for($i=0;$i<$tb_Member->admin;$i++)
                    <i class="fa fa-star text-warning"></i>
                @endfor
                </span>
            </div>
            @endif
            <div class="h5 mb-0">{{$tb_Member->name}}</div>
            <span class="badge @if($tb_Member->admin != 0) badge-warning @else badge-secondary @endif">{{$tb_Member->text_admin}}會員</span>
        </div>
        <div class="card-footer text-right">
            @if(Auth::user()->id == $tb_Member->id)
            <a href="{{url('/member/'.$tb_Member->account.'/edit')}}" class="btn btn-sm btn-outline-success pt-0 pb-0">編輯</a>
            @endif
        </div>
    </div>
    @if(count($tb_Shop)>0)
    <div class="card">
        <div class="card-header border-bottom border-light">
            <h4 class="card-title text-center mt-1">我的商家</h4>
        </div>
        <div class="card-body text-center">
            <div class="list-group">
                @foreach($tb_Shop as $Shop)
                <a href="{{url('/shop/'.$Shop->id)}}" class="list-group-item bg-dark">
                    <i class="fa fa-home mr-2"></i>{{$Shop->name}}
                </a>
                @endforeach
            </div>
        </div>
        <div class="card-footer text-right">
            @if(Auth::user()->id == $tb_Member->id)
            <a href="{{url('/member/'.$tb_Member->account.'/shop/list')}}" class="btn btn-sm btn-outline-success pt-0 pb-0">編輯</a>
            @endif
        </div>
    </div>
    @endif
@endsection
@section('nine')
    <div class="card">
        <div class="card-header border-bottom border-light">
            <h4 class="card-title text-center mt-1">留言板</h4>
        </div>
        <div class="card-body" style="min-height: 70vh;">
            
        </div>
        <div class="card-footer">
            < 1 2 3 >
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