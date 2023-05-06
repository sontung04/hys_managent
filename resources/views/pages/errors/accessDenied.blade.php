@extends('layouts.sidebar')

@section('title', 'Lỗi quyền truy cập')

@section('style')

@endsection

@section('script')

@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lỗi quyền truy cập</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="error-page">
                <h3 class="headline text-warning">Access Denied</h3>

                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Cảnh báo Quyền truy cập!</h3>

                    <p>
                        Bạn không có quyền truy cập trang này! <br>
                        Vui lòng quay lại hoặc liên hệ Admin! <br>
                        <a href="{{route('index')}}">Về trang chủ</a>
                    </p>

                </div>

            </div>

        </section>
    </div>

@endsection

