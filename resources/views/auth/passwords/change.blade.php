@extends('layouts.index')

@section('title', 'HYS Manage - Thay đổi mật khẩu')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Thay đổi mật khẩu') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.change') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="fullname" class="col-md-4 col-form-label text-md-right">{{ __('Họ và Tên :') }}</label>
                                <div class="col-md-4 col-form-label text-md-left">{{$user[0]->lastname . ' ' . $user[0]->firstname }}</div>
                            </div>
                            <div class="form-group row">
                                <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Mã thành viên :') }}</label>
                                <div class="col-md-4 col-form-label text-md-left">{{$user[0]->code}}</div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email :') }}</label>
                                <div class="col-md-4 col-form-label text-md-left">{{$user[0]->email}}</div>
                            </div>
                            <div class="form-group row">
                                <label for="current-password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu hiện tại') }}</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">
                                    @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message}}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="new-password" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu mới') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required autocomplete="new-password">

                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Xác nhận mật khẩu mới') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control" name="new_password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Lưu thay đổi') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
