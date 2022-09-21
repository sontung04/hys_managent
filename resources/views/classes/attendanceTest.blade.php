@extends('layouts.sidebar')

@section('style')
    <style>
        /*@media only screen and (max-width: 540px) {*/
        /*    #tableAtt {*/
        /*        display: block;*/
        /*        overflow-x: auto;*/
        /*    }*/
        /*}*/

        /*@media only screen and (max-width: 976px) {*/
        /*    #tableAtt {*/
        /*        display: block;*/
        /*        overflow-x: auto;*/
        /*    }*/
        /*}*/

    </style>
@endsection

@section('script')

@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Điểm danh lớp học</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">Danh sách điểm danh</li>
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
                                <h3 class="card-title"></h3>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  class="table table-striped table-hover" >
                                        <thead>
                                        <tr>
                                            <th >Học viên</th>
                                            <?php
                                            for ($i = 1; $i <= 15; $i++) {
                                                echo '<td>Buổi ' . $i . '</td>';
                                            }
                                            ?>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <img src="{{asset('themes/dist/img/user3-128x128.jpg')}}" alt="Product 1" class="img-circle img-size-32 mr-2">
                                                Bùi Minh Quang
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);">
                                                    <i class="fa fa-check text-success"></i>
                                                </a>
                                            </td>

                                            <?php
                                            for ($i = 0; $i < 14; $i++) {
                                                echo '<td>Ap</td>';
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Alexander Pierce</td>

                                            <?php
                                            for ($i = 0; $i < 15; $i++) {
                                                echo '<td>tr</td>';
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>657</td>

                                            <?php
                                            for ($i = 0; $i < 15; $i++) {
                                                echo '<td>Ba</td>';
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Mike Doe</td>
                                            <?php
                                            for ($i = 0; $i < 15; $i++) {
                                                echo '<td>fdg</td>';
                                            }
                                            ?>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
