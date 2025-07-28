<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- toaster style --}}-->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @yield('style')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">


        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Jony Store</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="nav-icon fas fa-user-tie"
                            style="color: #ccc; font-size: 28px; margin-right: 12px;"></i>
                    </div>
                    <div class="info">
                        <a href="{{route('admin.admins.show', auth('admin')->user()->id)}}" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @canany(['Create-Category', 'Read-Categories'], 'admin')
                            @include('admin.componets.nav-item', [
                                'routeName' => 'categories',
                                'label' => __('cms.categories'),
                                'icon' => 'fas fa-dice-d20',
                                'options' => [
                                    [
                                        'label' => __('cms.create'),
                                        'route' => 'admin.categories.create',
                                        'permission' => 'Create-Category'
                                    ],
                                    [
                                        'label' => __('cms.read'),
                                        'route' => 'admin.categories.index',
                                        'permission' => 'Read-Category'
                                    ],
                                ],
                            ])
                        @endcanany

                                 @canany(['Create-Product', 'Read-Products',], session('guard'))
                                    @include('admin.componets.nav-item', [
                                        'routeName' => 'products',
                                        'label' => __('cms.products'),
                                        'icon' => 'fas fa-lemon',
                                        'options' => [
                                            [
                                                'label' => __('cms.create'),
                                                'route' => 'admin.products.create',
                                                'permission' => 'Create-Product'
                                            ],
                                            [
                                                'label' => __('cms.read'),
                                                'route' => 'admin.products.index',
                                                'permission' => 'Read-Product'
                                            ],
                                            [
                                                'label' => __('cms.trash'),
                                                'route' => 'admin.products.trash',
                                                'permission' => 'Trash-Product'
                                            ],
                                        ],
                                    ])
                                   @endcanany
                                        @canany(['Create-Role', 'Read-Roles'], 'admin')
                                            @include('admin.componets.nav-item', [
                                                'routeName' => 'roles',
                                                'label' => __('cms.roles'),
                                                'icon' => 'fas fa-dice-d20',
                                                'options' => [
                                                    [
                                                        'label' => __('cms.create'),
                                                        'route' => 'admin.roles.create',
                                                        'permission' => 'Create-Role'
                                                    ],
                                                    [
                                                        'label' => __('cms.read'),
                                                        'route' => 'admin.roles.index',
                                                        'permission' => 'Read-Roles'
                                                    ],
                                                ],
                                            ])
                                        @endcanany

                    @canany(['Create-Admin', 'Read-Admins'], 'admin')
                        <li class="nav-header">{{__('cms.hr')}}</li>
                    @endcanany
                    @canany(['Create-Admin', 'Read-Admins'], 'admin')
                        @include('admin.componets.nav-item', [
                            'routeName' => 'admin',
                            'label' => __('cms.admins'),
                            'icon' => 'fas fa-dice-d20',
                            'options' => [
                                [
                                    'label' => __('cms.create'),
                                    'route' => 'admin.admins.create',
                                    'permission' => 'Create-Admin'

                                ],
                                [
                                    'label' => __('cms.read'),
                                    'route' => 'admin.admins.index',
                                    'permission' => 'Read-Admins'
                                ],
                            ],
                        ])
                    @endcanany

                    @canany(['Create-User', 'Read-Users'], 'admin')
                        @include('admin.componets.nav-item', [
                            'routeName' => 'user',
                            'label' => __('cms.users'),
                            'icon' => 'fas fa-user-tie',
                            'options' => [
                                [
                                    'label' => __('cms.create'),
                                    'route' => 'admin.users.create',
                                    'permission' => 'Create-User'

                                ],
                                [
                                    'label' => __('cms.read'),
                                    'route' => 'admin.users.index',
                                    'permission' => 'Read-Users'
                                ],
                            ],
                        ])
                    @endcanany

                    @canany(['Create-Vendor', 'Read-Vendors'], 'admin')
                        @include('admin.componets.nav-item', [
                            'routeName' => 'vendor',
                            'label' => __('cms.vendors'),
                            'icon' => 'fas fa-user-tie',
                            'options' => [
                                [
                                    'label' => __('cms.create'),
                                    'route' => 'admin.vendors.create',
                                    'permission' => 'Create-vendor'

                                ],
                                [
                                    'label' => __('cms.read'),
                                    'route' => 'admin.vendors.index',
                                    'permission' => 'Read-vendors'
                                ],
                            ],
                        ])
                    @endcanany

                    <li class="nav-item">
                        <a href="{{ route('admin.logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                {{ __('cms.logout') }}
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <aside class="control-sidebar control-sidebar-dark">
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
            <strong>Copyright &copy; 2014-2025 <a href="{{route('products.index')}}">Electronic Jony</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    @yield('script')
</body>

</html>
