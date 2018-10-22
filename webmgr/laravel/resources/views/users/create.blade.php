@extends('layouts.master')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="nav-icon fa fa-id-card-o mr-1"></i>管理中心<small><i class="fa fa-chevron-right m-1"></i>新增管理員</small></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">總覽</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/users')}}">管理中心</a></li>
                    <li class="breadcrumb-item active">新增管理員</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"></div>
                <form action='{{url('/users/create')}}' method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="name" class="col-sm-1">*管理員名稱</label>
                            <div class="col-sm-5">
                                <input type="text" id="name" name="name" class="form-control" placeholder="英文50字,中文25字,含空格" @if(old('name')) value="{{ old('name') }}" @endif >
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="email" class="col-sm-1">*帳號(Email)</label>
                            <div class="col-sm-5">
                                <input type="email" id="email" name="email" class="form-control" @if(old('email')) value="{{ old('email') }}" @endif>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="password" class="col-sm-1">*密碼</label>
                            <div class="col-sm-5">
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="password_confirmation" class="col-sm-1">*確認密碼</label>
                            <div class="col-sm-5">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="admin" class="col-sm-1">*權限等級</label>
                            <div class="col-sm-5">
                                <select name="admin" id="admin" class="form-control">
                                    <option value="1" @if(old('admin')) @if(old('admin') == 1) selected @endif @else selected @endif>一般</option>
                                    <option value="0" @if(old('admin')) @if(old('admin') == 0) selected @endif @endif>最高</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('/users') }}" class="btn btn-secondary">
                            取消
                        </a>
                        <button type="submit"  class="btn btn-primary">
                            儲存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection