@extends('layouts.navbar')
@section('sidebar')
    <?php
        $user = \Illuminate\Support\Facades\Auth::user();
    ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('index')}}" class="brand-link">
            <img src="{{ asset('assets/img/HYSLogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">HYS Manager</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset($user->img) }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{route('user.profile')}} " class="d-block">{{$user->lastname . ' ' . $user->firstname }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <!-- User Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/user') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/user') !== false) active @endif">
                            <i class="fas fa-user nav-icon"></i>
                            <p>
                                Người dùng
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('user.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/user/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách thành viên</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('user.create')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/user/create') !== false) active @endif">
                                    <i class="fas fa-user-plus nav-icon"></i>
                                    <p>Tạo người dùng mới</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Group, Department Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/group') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/group') !== false) active @endif">
                            <i class="fas fa-layer-group nav-icon"></i>
                            <p>
                                Khu vực, phòng ban
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('group.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/group/list') !== false) active @endif">
                                    <i class="fas fa-home"></i>
                                    <p>DS Khu vực, phòng ban</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('group.manage')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/group/manage') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Quản lý chung</p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('group.test')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/group/test') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Group Test</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Event Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/event') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/event') !== false) active @endif" >
                            <i class="fas fa-fire nav-icon"></i>
                            <p>
                                Sự kiện
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('event.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/event/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách sự kiện</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-calendar-plus nav-icon"></i>
                                    <p>Tạo sự kiện mới</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Calendar Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/calendar') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/calendar') !== false) active @endif">
                            <i class="fa-solid fa-calendar"></i>
                            <p>
                                Lịch hoạt động
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('calendar.weekHys')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/calendar/weekHys') !== false) active @endif">
                                    <i class="fa-solid fa-calendar-week"></i>
                                    <p>Lịch tuần HYS</p>
                                </a>
                            </li>
                        </ul>

                    </li>
                </ul>

                <!-- Course Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/course') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/course') !== false) active @endif">
                            <i class="fas fa-book-open"></i>
                            <p>
                                Khóa học
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('course.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/course/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách khóa học</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('course.teacherList')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/course/teacher') !== false) active @endif">
                                    <i class="fa-solid fa-person-chalkboard"></i>
                                    <p>Danh sách Giảng viên</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Lesson Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/lesson') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/lesson') !== false) active @endif">
                            <i class="fas fa-graduation-cap nav-icon"></i>
                            <p>
                                Bài học
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('lesson.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/lesson/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách bài học</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Class Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/class') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/class') !== false) active @endif">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <p>
                                Lớp học
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('class.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/class/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách lớp học</p>
                                </a>
                            </li>
                        </ul>
{{--                        <ul class="nav nav-treeview">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="" class="nav-link">--}}
{{--                                    <i class="fas fa-list nav-icon"></i>--}}
{{--                                    <p>Danh sách sự kiện</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
                    </li>
                </ul>
                <!-- Student Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/student') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/student') !== false) active @endif">
                            <i class="fas fa-user-graduate"></i>
                            <p>
                                Học Viên
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('student.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/student/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách Học viên</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('s.fee.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/fee/list') !== false) active @endif">
                                    <i class="fa-solid fa-sack-dollar"></i>
                                    <p>Danh sách Học phí</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Intern Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/intern') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/intern') !== false) active @endif">
                            <i class="fa fa-drivers-license"></i>
                            <p>
                                Thực tập sinh
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('intern.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/intern/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Danh sách TTS</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Contact Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview ">
                        <a href="#" class="nav-link">
                            <i class="fas fa-address-book"></i>
                            <p>
                                Contact
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                    </li>
                </ul>


                <!-- Role Menu -->
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(strpos($_SERVER['REQUEST_URI'], '/role') !== false) menu-open @endif">
                        <a href="#" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/role') !== false) active @endif">
                            <i class="fas fa-user-tag"></i>
                            <p>
                                Chức vụ
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('role.list')}}" class="nav-link @if(strpos($_SERVER['REQUEST_URI'], '/role/list') !== false) active @endif">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Các chức vụ HYS</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
@endsection
