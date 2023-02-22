@extends('layouts.index')

@section('title', 'Lỗi 404')

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
                    <h2 class="headline text-warning"> 404</h2>

                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Lỗi đường dẫn rồi!</h3>

                        <p>
                            Đường dẫn của bạn không chính xác! <br>
                            Vui lòng kiểm tra lại đường dẫn hoặc liên hệ Admin! <br>
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
