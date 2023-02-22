@extends('layouts.index')

@section('title', 'Lỗi 403')

@section('style')

@endsection

@section('script')

@endsection

@section('content')
    <div class="card">
        <!-- Main content -->
        <div class="card-body">
            <section class="content">
                <div class="error-page">
                    <h2 class="headline text-warning"> 403</h2>

                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Cảnh báo Quyền truy cập!</h3>

                        <p>
                            Bạn không có quyền truy cập trang này! <br>
                            Vui lòng quay lại hoặc liên hệ Admin! <br>
                            <a href="{{route('index')}}">Về trang chủ</a>
                        </p>

                    </div>
                    <!-- /.error-content -->
                </div>
                <!-- /.error-page -->
            </section>
        </div>
        <!-- /.content -->
    </div>
@endsection

