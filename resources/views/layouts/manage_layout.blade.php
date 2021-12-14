<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>AdminLTE 3 | Starter</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="/css/app.css" />
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper" id="app">
            <!-- Navbar -->
            <nav
                class="
                    main-header
                    navbar navbar-expand navbar-white navbar-light
                "
            >
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="pushmenu"
                            href="#"
                            role="button"
                            ><i class="fas fa-bars"></i
                        ></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    @yield('notification')
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="fullscreen"
                            href="#"
                            role="button"
                        >
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-widget="control-sidebar"
                            data-slide="true"
                            href="#"
                            role="button"
                        >
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="#" class="brand-link logo-switch bg-white">
                    <img
                        src="/img/logo-xs.png"
                        alt="AdminLTE Docs Logo Small"
                        class="brand-image-xl logo-xs"
                    />
                    <img
                        src="/img/logo-xl.png"
                        alt="AdminLTE Docs Logo Large"
                        class="brand-image-xs logo-xl"
                        style="left: 12px"
                    />
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img
                                src="{{ asset('/img/user.png') }}"
                                class="img-circle elevation-2"
                                alt="User Image"
                            />
                        </div>
                        <div class="info">
                            <router-link
                                to="/manage/profile"
                                exact-active-class="active"
                            >
                                {{ Auth::user()->name }}
                            </router-link>
                        </div>
                    </div>

                    <!-- SidebarSearch Form -->
                    <div class="form-inline">
                        <div class="input-group" data-widget="sidebar-search">
                            <input
                                class="form-control form-control-sidebar"
                                type="search"
                                placeholder="Search"
                                aria-label="Search"
                            />
                            <div class="input-group-append">
                                <button class="btn btn-sidebar">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul
                            class="nav nav-pills nav-sidebar flex-column"
                            data-widget="treeview"
                            role="menu"
                            data-accordion="false"
                        >
                            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                            @can('view dashboard')
                            <li class="nav-item">
                                <router-link
                                    to="/manage/dashboard"
                                    class="nav-link"
                                >
                                    <i
                                        class="
                                            nav-icon
                                            fas
                                            fa-tachometer-alt
                                            text-yellow
                                        "
                                    ></i>
                                    <p>Dashboard</p>
                                </router-link>
                            </li>
                            @endcan
                            <li class="nav-item menu-open">
                                <a href="#" class="nav-link">
                                    <i
                                        class="nav-icon fas fa-cog text-orange"
                                    ></i>
                                    <p>
                                        Management
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view users')
                                    <li class="nav-item">
                                        <router-link
                                            to="/manage/users"
                                            class="nav-link"
                                        >
                                            <i
                                                class="
                                                    fas
                                                    fa-users
                                                    nav-icon
                                                    text-cyan
                                                "
                                            ></i>
                                            <p>Users</p>
                                        </router-link>
                                    </li>
                                    @endcan @can('view roles')
                                    <li class="nav-item">
                                        <router-link
                                            to="/manage/roles"
                                            class="nav-link"
                                        >
                                            <i
                                                class="
                                                    fas
                                                    fa-certificate
                                                    nav-icon
                                                    text-pink
                                                "
                                            ></i>
                                            <p>Roles & Permissions</p>
                                        </router-link>
                                    </li>
                                    @endcan
                                </ul>
                            </li>

                            <li class="nav-item">
                                <router-link
                                    to="/manage/profile"
                                    class="nav-link"
                                >
                                    <i
                                        class="
                                            fa fa-id-card
                                            nav-icon
                                            text-white
                                        "
                                    ></i>
                                    <p>Profile</p>
                                </router-link>
                            </li>
                            <li class="nav-item"></li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    href="#"
                                    @click.prevent="logout"
                                >
                                    <i
                                        class="
                                            nav-icon
                                            fas
                                            fa-power-off
                                            text-red
                                        "
                                    ></i>
                                    <p>
                                        {{ __('Logout') }}
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <!-- <h1 class="m-0">Starter Page</h1> -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <span class="float-sm-right"> Date: </span>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <router-view></router-view>
                        <vue-progress-bar></vue-progress-bar>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong
                    >Copyright &copy; 2014-2021
                    <a href="https://adminlte.io">AdminLTE.io</a>.</strong
                >
                All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script>
            @auth
              window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
            @else
              window.Permissions = [];
            @endauth
        </script>

        <!-- REQUIRED SCRIPTS -->
        <script src="/js/app.js"></script>
    </body>
</html>
