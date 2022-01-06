@extends('layouts.sidebar')
@section('script')

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/group.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>HYS name</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Trang chủ</a></li>
                            <li class="breadcrumb-item active">HYS name</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Banner -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-widget widget-user">
                            <div class="widget-user-header text-white"
                                 style="background: url({{ asset('themes/dist/img/photo1.png') }} ) center center;">
                                <h3 class="widget-user-username ">CLB Thanh niên khởi nghiệp Hà Nội</h3>
                                <h5 class="widget-user-desc"></h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="{{ asset('themes/dist/img/user3-128x128.jpg') }}" alt="User Avatar">
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Thành viên</h5>
                                            <span class="description-text">3,200</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 border-right">
                                        <div class="description-block">
                                            <h5 class="description-header">Khu vực</h5>
                                            <span class="description-text">7</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4">
                                        <div class="description-block">
                                            <h5 class="description-header">Ban chuyên môn</h5>
                                            <span class="description-text">6</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Banner -->

                <div class="row">
                    <div class="col-md-2">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Giới thiệu</h3>
                            </div>
                            <div class="card-body">

                                <strong><i class="fas fa-birthday-cake"></i> Ngày kỷ niệm </strong>
                                <p class="text-muted">
                                    17/11
                                </p>

                                <hr>

                                <strong><i class="fas fa-music"></i> Bài hát truyền thống </strong>
                                <p class="text-muted">Malibu, California</p>

                                <hr>

                                <strong><i class="fas fa-paint-brush"></i> Màu sắc truyền thống </strong>
                                <p class="text-muted">Malibu, California</p>

                                <hr>

                                <strong><i class="fas fa-home"></i> Địa chỉ </strong>
                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Liên hệ</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <div class="nav-link">
                                            <strong><i class="far fa-envelope" style="color: crimson"></i> Email </strong>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="" target="_blank">
                                            <strong><i class="fab fa-facebook-square" style="color: dodgerblue"></i> Facebook </strong>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <strong><i class="fab fa-youtube"  style="color: red"></i> Youtube </strong>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <i class="fab fa-tiktok"></i>
                                            <strong><i class="fab fa-instagram-square" id="instaIcon" ></i> Instagram </strong>
                                        </a>
                                    </li>
{{--                                    <li class="nav-item">--}}
{{--                                        <a class="nav-link" href="#" target="_blank">--}}
{{--                                            <strong><i class="fab fa-tiktok"></i> Tiktok </strong>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-10">
                        <div class="card card-primary card-outline">

                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Mô tả</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#human" data-toggle="tab">Nhân sự</a></li>
                                </ul>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">

                                        <div class="mailbox-read-message">
                                            <p>Hello John,</p>

                                            <p>Keffiyeh blog actually fashion axe vegan, irony biodiesel. Cold-pressed hoodie chillwave put a bird
                                                on it aesthetic, bitters brunch meggings vegan iPhone. Dreamcatcher vegan scenester mlkshk. Ethical
                                                master cleanse Bushwick, occupy Thundercats banjo cliche ennui farm-to-table mlkshk fanny pack
                                                gluten-free. Marfa butcher vegan quinoa, bicycle rights disrupt tofu scenester chillwave 3 wolf moon
                                                asymmetrical taxidermy pour-over. Quinoa tote bag fashion axe, Godard disrupt migas church-key tofu
                                                blog locavore. Thundercats cronut polaroid Neutra tousled, meh food truck selfies narwhal American
                                                Apparel.</p>

                                            <p>Raw denim McSweeney's bicycle rights, iPhone trust fund quinoa Neutra VHS kale chips vegan PBR&amp;B
                                                literally Thundercats +1. Forage tilde four dollar toast, banjo health goth paleo butcher. Four dollar
                                                toast Brooklyn pour-over American Apparel sustainable, lumbersexual listicle gluten-free health goth
                                                umami hoodie. Synth Echo Park bicycle rights DIY farm-to-table, retro kogi sriracha dreamcatcher PBR&amp;B
                                                flannel hashtag irony Wes Anderson. Lumbersexual Williamsburg Helvetica next level. Cold-pressed
                                                slow-carb pop-up normcore Thundercats Portland, cardigan literally meditation lumbersexual crucifix.
                                                Wayfarers raw denim paleo Bushwick, keytar Helvetica scenester keffiyeh 8-bit irony mumblecore
                                                whatever viral Truffaut.</p>

                                            <p>Post-ironic shabby chic VHS, Marfa keytar flannel lomo try-hard keffiyeh cray. Actually fap fanny
                                                pack yr artisan trust fund. High Life dreamcatcher church-key gentrify. Tumblr stumptown four dollar
                                                toast vinyl, cold-pressed try-hard blog authentic keffiyeh Helvetica lo-fi tilde Intelligentsia. Lomo
                                                locavore salvia bespoke, twee fixie paleo cliche brunch Schlitz blog McSweeney's messenger bag swag
                                                slow-carb. Odd Future photo booth pork belly, you probably haven't heard of them actually tofu ennui
                                                keffiyeh lo-fi Truffaut health goth. Narwhal sustainable retro disrupt.</p>

                                            <p>Skateboard artisan letterpress before they sold out High Life messenger bag. Bitters chambray
                                                leggings listicle, drinking vinegar chillwave synth. Fanny pack hoodie American Apparel twee. American
                                                Apparel PBR listicle, salvia aesthetic occupy sustainable Neutra kogi. Organic synth Tumblr viral
                                                plaid, shabby chic single-origin coffee Etsy 3 wolf moon slow-carb Schlitz roof party tousled squid
                                                vinyl. Readymade next level literally trust fund. Distillery master cleanse migas, Vice sriracha
                                                flannel chambray chia cronut.</p>

                                            <p>Thanks,<br>Jane</p>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="human">
                                        <div class="card">
                                            <div class="card-header" >
                                                <h3 class="text-center" >Danh sách Thủ Lĩnh</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>User</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Reason</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>183</td>
                                                        <td>John Doe</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-success">Approved</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>219</td>
                                                        <td>Alexander Pierce</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-warning">Pending</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>657</td>
                                                        <td>Bob Doe</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-primary">Approved</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    <tr>
                                                        <td>175</td>
                                                        <td>Mike Doe</td>
                                                        <td>11-7-2014</td>
                                                        <td><span class="tag tag-danger">Denied</span></td>
                                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </section>
    </div>
@endsection

