@extends('layouts.sidebar')

@section('script')
    <script src="{{ asset('assets/js/class/attendance.js') }}" defer></script> 
 @endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/class/attendance.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bảng điểm danh lớp ABC</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Danh sách khóa học</li>
                    </ol>
                </div>
            </div>
        </div>    
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-success text-white float-right" id="insertCol">
                                <i class="fas fa-cog"></i>
                                    Thêm buổi học mới
                            </a>  
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class = "scrolling-lock-table-wrapper">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead style="text-align: center;">
                                        <tr id="row1">
                                            <th class="fixed-side1" style="height: 80px">
                                                STT
                                                <br>
                                                <!-- <button style="width:2vw; text-align: centre"
                                                    class="pull-right btn btn-default btn-condensed hide-column" data-toggle="tooltip"
                                                    data-placement="bottom" title="Ẩn cột">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button> -->
                                            </th>

                                            <th class="fixed-side2" style="height: 80px">
                                                Họ Tên
                                                <br>
                                                <!-- <button class="pull-right btn btn-default btn-condensed hide-column hoTen"
                                                    data-toggle="tooltip" data-placement="bottom" title="Ẩn cột">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button> -->
                                            </th class="hide-col">
                                            <th>
                                                SĐT
                                                <br>
                                                <button class="pull-right btn btn-default btn-condensed hide-column sdt"
                                                    data-toggle="tooltip" data-placement="bottom" title="Ẩn cột">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                            </th>

                                            <th>
                                                Ngày sinh
                                                <br>
                                                <button class="pull-right btn btn-default btn-condensed hide-column ngaySinh"
                                                    data-toggle="tooltip" data-placement="bottom" title="Ẩn cột">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                            </th>
                                            </th class="hide-col">
                                            <th>
                                                Giới tính
                                                <br>
                                                <button class="pull-right btn btn-default btn-condensed hide-column gioiTinh"
                                                    data-toggle="tooltip" data-placement="bottom" title="Ẩn cột">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody id="myTable">


                                        <tr id="row2">
                                            <td class="fixed-side1">1</td>
                                            <td class="hoTen fixed-side2" >Edinburgh</td>
                                            <td class="sdt">03432425</td>
                                            <td class="ngaySinh">17/02/2002</td>
                                            <td class="gioiTinh">Nam</td>
                                        </tr>
                                        <tr id="row3">
                                            <td class="fixed-side1">1</td>
                                            <td class="hoTen fixed-side2">Edinburgh</td>
                                            <td class="sdt">03432425</td>
                                            <td class="ngaySinh">17/02/2002</td>
                                            <td class="gioiTinh">Nam</td>
                                        </tr>
                                        <tr id="row4">
                                            <td class="fixed-side1">1</td>
                                            <td class="hoTen fixed-side2">Edinburgh</td>
                                            <td class="sdt">03432425</td>
                                            <td class="ngaySinh">17/02/2002</td>
                                            <td class="gioiTinh">Nam</td>
                                        </tr>
                                        <tr id="row5">
                                            <td class="fixed-side1">1</td>
                                            <td class="hoTen fixed-side2">Edinburgh</td>
                                            <td class="sdt">03432425</td>
                                            <td class="ngaySinh">17/02/2002</td>
                                            <td class="gioiTinh">Nam</td>
                                        </tr>

                                    </tbody>
                                    <tfoot class="footer-restore-columns" >
                                   
                                    <tr class="footer-restore-columns">
                                            <th colspan="2" style="width: 260px; flex-wrap: wrap"><a class="restore-columns" href="#" style="color: green" >Một số cột có thể đã bị ẩn - Ấn vào đây để hiển thị tất cả</a></th>
                                    </tr>
                                     
                                    </tfoot>
                                </table>

                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>


    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin buổi học</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formInput-add">
                        <div class="form-group row">
                            <label class="col-md-3" for="inputName">Chủ nhiệm</label>
                            <input type="text" class="col-md-9 form-control" id="inputName" name="name"
                                aria-describedby="emailHelp" placeholder="Tên chủ nhiệm" />
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputPrice">Trợ giảng</label>
                            <input type="" name="price" class="col-md-9 form-control" id="inputPrice"
                                placeholder="Tên trợ giảng" />
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputDescription">Giảng viên</label>
                            <input type="" name="description" class="col-md-9 form-control" id="inputDescription"
                                placeholder="Tên giảng viên" />
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputQuantity">Nội dung buổi học</label>

                            <input type="" name="product_site" class="col-md-9 form-control" id="inputProductSite"
                                placeholder="" />
                            <!-- <textarea id="w3review" name="w3review" rows="4" cols="50"></textarea> -->
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputProductSite">Nhận xét</label>
                            <textarea type="" name="quantity" class="col-md-9 form-control" id="inputQuantity"
                                placeholder=""></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary saveNewInfo">Lưu</button>
                            <button type="button" class="btn btn-secondary btnClose-add"
                                data-dismiss="modal">Đóng</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông tin buổi học</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formInput-add">
                        <div class="form-group row">
                            <label class="col-md-3" for="inputName">Chủ nhiệm</label>
                            <input type="text" class="col-md-9 form-control" id="inputName" name="name"
                                aria-describedby="emailHelp" placeholder="Tên chủ nhiệm" />
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputPrice">Trợ giảng</label>
                            <input type="" name="price" class="col-md-9 form-control" id="inputPrice"
                                placeholder="Tên trợ giảng" />
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputDescription">Giảng viên</label>
                            <input type="" name="description" class="col-md-9 form-control" id="inputDescription"
                                placeholder="Tên giảng viên" />
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputQuantity">Nội dung buổi học</label>

                            <input type="" name="product_site" class="col-md-9 form-control" id="inputProductSite"
                                placeholder="" />
                            <!-- <textarea id="w3review" name="w3review" rows="4" cols="50"></textarea> -->
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3" for="inputProductSite">Nhận xét</label>
                            <textarea type="" name="quantity" class="col-md-9 form-control" id="inputQuantity"
                                placeholder=""></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary addNewInfo" data-toggle="modal"
                                data-target="#mModal">Chỉnh sửa</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection
