@extends('layouts.content.three-nine')
@section('css')
<link href="{{url('css/panel.css')}}" rel="stylesheet">
@endsection
@section('three')
<div class="card">
    <div class="card-header">
        <a href="{{url('/member/'.$tb_Member->id)}}" class="btn btn-outline-success">
            <i class="fa fa-arrow-left mr-1"></i>返回個人頁面
        </a>
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
@endsection
@section('nine')
        <div class="card">
            <div class="card-header border-bottom border-light">
                <h4 class="card-title text-center mt-1">創立商家</h4>
            </div>
            <form action="{{url('/member/'.$tb_Member->id.'/shop/create')}}" method="post">
                {{csrf_field()}}
                <div class="card-body d-flex justify-content-center">
                    <div class="col-sm-8">
                        <div class="row form-group">
                            <label for="nickname" class="col-md-3 col-form-label">商家名稱</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="nickname" id="nickname" class="form-control bg-dark text-light" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="name" class="col-md-3 col-form-label">出貨人姓名</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="name" id="name" class="form-control bg-dark text-light">
                                <span class="btn btn-outline-warning ml-1" onclick="auto_input($('#nickname').val(),'name');">同商家名稱</span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="taxid" class="col-md-3 col-form-label">統一編號</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="taxid" id="taxid" class="form-control bg-dark text-light">
                            </div>
                        </div>
                        <div id="email-input" class="row form-group">
                            <label for="email" class="col-md-3 col-form-label">電子郵件</label>
                            <div class="input-group col-md-9">
                                <input type="email" name="email" class="form-control bg-dark text-light">
                                <span class="btn btn-outline-warning ml-1" onclick="auto_input('{{$tb_Member->email}}','email');">同會員帳號</span>
                            </div>
                        </div>
                        <div id="phone-input" class="row form-group">
                            <label for="phone" class="col-md-3 col-form-label">連絡電話</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="phone" class="form-control bg-dark text-light">
                                <span class="btn btn-outline-warning ml-1" onclick="auto_input('{{json_decode($tb_Member->info)->phone[0]}}','phone');">同會員電話</span>
                            </div>
                        </div>
                        <div id="address-input" class="row form-group">
                            <label for="address" class="col-md-3 col-form-label">出貨地址</label>
                            <div class="input-group col-md-9">
                                <input type="text" name="address" class="form-control bg-dark text-light">
                                <span class="btn btn-outline-warning ml-1" onclick="auto_input('{{json_decode($tb_Member->info)->address[0]}}','address');">同會員地址</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 d-md-block d-none"></div>
                </div>
                @if (count($errors) > 0)
                <div class="d-flex justify-content-center">
                    <div class="col-sm-6">
                        <div class="alert alert-dark">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                <div class="card-footer border-top border-light d-flex justify-content-around">
                    <div class="offset-sm-1 col-sm-6 d-flex justify-content-center">
                        <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-file-text mr-2"></i>申請</button>
                    </div>
                </div>
            </form>
        </div>
@endsection
@section('js')
<script>
    function auto_input(value,name) {
        console.log(value);
        $("input[name='"+name+"']").val(value);
    }
</script>
@endsection