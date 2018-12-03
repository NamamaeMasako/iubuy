@extends('layouts.content.three-nine')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('three')
<div class="card">
    <div class="card-header">
        <div class="col-xl-12 d-lg-flex align-items-center mb-3">
            <div class="col-xl-5">
                <img src="{{url('/webmgr/upload/members/'.$tb_Member->avator)}}" class="w-100 rounded-circle p-0" alt="Member Img" onerror="javascript:this.src='{{url('/webmgr/img/default_avator.jpg')}}'">
            </div>
            <div class="col-xl-7 col-lg-12">
                <span>{{$tb_Member->name}}</span>
                <span class="badge @if($tb_Member->admin != 0) badge-warning @else badge-secondary @endif">{{$tb_Member->text_admin}}會員</span>
            </div>
        </div>
        <div class="col-xl-12">
            <a href="{{url('/member/'.$tb_Member->account)}}" class="btn btn-outline-success">
                <i class="fa fa-arrow-left mr-1"></i>返回個人頁面
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="{{url('/member/'.$tb_Member->account.'/edit')}}" class="list-group-item text-light bg-success"><i class="fa fa-pencil mr-1"></i>編輯會員資資訊</a>
            @if($tb_Member->admin != 0)
            <a href="{{url('/member/'.$tb_Member->account.'/shop/list')}}" class="list-group-item bg-dark"><i class="fa fa-file-text mr-1"></i>擁有商家清單</a>
            @endif
        </div>
    </div>
</div>
@endsection
@section('nine')
<div class="card">
    <div class="card-header border-bottom border-light">
        <h4 class="card-title text-center mt-1">帳號資訊</h4>
    </div>
    <div class="card-body d-flex justify-content-center">
        <div class="col-12 d-md-flex justify-content-center">
            <form action="{{url('/member/'.$tb_Member->account.'/edit')}}" method="post" class="col-md-3 col-6 text-center" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('patch')}}
                <img src="{{url('/webmgr/upload/members/'.$tb_Member->avator)}}" class="col-sm-12 rounded-circle" alt="Member Img" onerror="javascript:this.src='{{url('/webmgr/img/default_avator.jpg')}}'">
                <label for="avator" class="btn btn-success mt-3"><i class="fa fa-upload mr-2"></i>更新頭像</label>
                <input type="file" class="d-none" name="avator" id="avator" onchange="this.form.submit();">
            </form>
            <form action="{{url('/member/'.$tb_Member->account.'/edit/')}}" class="col-md-8 col-12" method="post">
                {{csrf_field()}}
                {{method_field('patch')}}
                <div class="row form-group">
                    <label for="account" class="col-sm-3 col-form-label">帳號</label>
                    <div class="input-group col-sm-9">
                        <span class="col-form-label">{{$tb_Member->account}}</span>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="nickname" class="col-sm-3 col-form-label">暱稱</label>
                    <div class="input-group col-sm-9">
                        <input type="text" name="nickname" id="nickname" class="form-control bg-dark text-light" value="{{$tb_Member->name}}" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-9 offset-sm-3">
                        <span>{{$tb_Member->text_admin}}</span>會員
                        <a href="" class="btn btn-sm btn-outline-warning pt-0 pb-0">提升</a>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="email" class="col-sm-3 col-form-label">綁定電子郵件</label>
                    <div class="input-group col-sm-9">
                        <input type="email" name="email" id="email" class="form-control bg-dark text-light" value="{{$tb_Member->email}}" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="email" class="col-sm-3 col-form-label">綁定電話</label>
                    <div class="input-group col-sm-9">
                        <input type="text" name="phone" id="phone" class="form-control bg-dark text-light" value="{{$tb_Member->phone}}" required>
                    </div>
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
        <h4 class="card-title text-center mt-1">個人資訊</h4>
    </div>
    <div class="card-body d-flex justify-content-center">
        <div class="col-12 d-md-flex justify-content-center">
            <form action="{{url('/member/'.$tb_Member->account.'/edit/')}}" class="col-md-8 col-12" method="post">
                {{csrf_field()}}
                {{method_field('patch')}}
                <div class="row form-group">
                    <label for="name" class="col-sm-3 col-form-label">真實姓名</label>
                    <div class="input-group col-sm-9">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark text-light">姓</span>
                        </div>
                        <input type="text" name="real_last_name" id="name" class="form-control bg-dark text-light" value="{{$tb_MemberProfile->real_last_name}}" required>
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark text-light">名</span>
                        </div>
                        <input type="text" name="real_first_name" id="name" class="form-control bg-dark text-light" value="{{$tb_MemberProfile->real_first_name}}" required>
                    </div>
                </div>
                <div class="row form-group">
                    <label for="gender" class="col-sm-3 col-form-label">性別</label>
                    <div class="btn-group btn-group-toggle ml-3" data-toggle="buttons">
                        @if($tb_MemberProfile->gender == 'male')
                        <label class="btn btn-secondary" onclick="radio_check.call(this);">
                            <input type="radio" name="gender" autocomplete="off" value="male" checked>男
                        </label>
                        @else
                        <label class="btn btn-outline-secondary" onclick="radio_check.call(this);">
                            <input type="radio" name="gender" autocomplete="off" value="male">男
                        </label>
                        @endif
                        @if($tb_MemberProfile->gender == 'female')
                        <label class="btn btn-secondary" onclick="radio_check.call(this);">
                            <input type="radio" name="gender" autocomplete="off" value="female" checked>女
                        </label>
                        @else
                        <label class="btn btn-outline-secondary" onclick="radio_check.call(this);">
                            <input type="radio" name="gender" autocomplete="off" value="female">女
                        </label>
                        @endif
                        @if($tb_MemberProfile->gender == 'other')
                        <label class="btn btn-secondary" onclick="radio_check.call(this);">
                            <input type="radio" name="gender" autocomplete="off" value="other" checked>其他
                        </label>
                        @else
                        <label class="btn btn-outline-secondary" onclick="radio_check.call(this);">
                            <input type="radio" name="gender" autocomplete="off" value="other">其他
                        </label>
                        @endif
                    </div>
                </div>
                <div id="email-input" class="row form-group">
                    <label for="email" class="col-sm-3 col-form-label">備援電子郵件</label>
                    @if(!empty($tb_MemberProfile->spare_email))
                        @foreach(json_decode($tb_MemberProfile->spare_email) as $idx => $email_row)
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
                    @else
                        <div class="input-group col-sm-9">
                            <input type="text" name="email[]" class="form-control bg-dark text-light" value="">
                            <span class="btn btn-outline-success ml-1" onclick="increase_input('email','email');"><i class="fa fa-plus"></i></span>
                        </div>
                    @endif
                </div>
                <div id="phone-input" class="row form-group">
                    <label for="phone" class="col-sm-3 col-form-label">備援電話</label>
                    @if(!empty($tb_MemberProfile->spare_phone))
                        @foreach(json_decode($tb_MemberProfile->spare_phone) as $idx => $phone_row)
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
                    <label for="address" class="col-sm-3 col-form-label">收貨地址</label>
                    @if(!empty($tb_MemberProfile->address))
                        @foreach(json_decode($tb_MemberProfile->address) as $idx => $address_row)
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