<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=9"/>
    <meta name="robots" content="nofollow,noindex"/>

    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <!-- Title -->
    <title>{{$page_title}}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('assets/images/favicons/apple-icon-57x57.png')}}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('assets/images/favicons/apple-icon-60x60.png')}}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('assets/images/favicons/apple-icon-72x72.png')}}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/images/favicons/apple-icon-76x76.png')}}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('assets/images/favicons/apple-icon-114x114.png')}}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/images/favicons/apple-icon-120x120.png')}}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('assets/images/favicons/apple-icon-144x144.png')}}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('assets/images/favicons/apple-icon-152x152.png')}}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/images/favicons/apple-icon-180x180.png')}}" />
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('assets/images/favicons/android-icon-192x192.png')}}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/favicons/favicon-32x32.png')}}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('assets/images/favicons/favicon-96x96.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicons/favicon-16x16.png')}}" />
    <link rel="manifest" href="{{asset('assets/images/favicons/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('assets/images/favicons/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">

    <!-- Icons css -->
    <link href="{{asset('assets/back/css/icons.css')}}" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="{{asset('assets/back/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/css/plugins.css')}}" rel="stylesheet"/>

    <!-- style css -->
    <link href="{{asset('assets/back/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    <!-- JQuery min js -->
    <script src="{{asset('assets/back/plugins/jquery/jquery.min.js')}}"></script>

    <style>
        body * {
            font-family: 'Cairo', sans-serif;
        }

        /* Hide arrows for Chrome, Safari, Edge, and Opera */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide arrows for Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 10px;
        }

        .dl-table td {
            vertical-align: middle;
        }

        .no-records {
            text-align: center;
            color: #CCCCCC
        }

        .no-records .big-icon {
            font-size: 60px;
        }

        .badge.badge-dl {
            font-size: 13px;
            padding: 10px 20px !important;
            display: inline-block;
            font-family: inherit;
            border-radius: 12px;
        }

        .table-dl th,
        .table-dl td {
            vertical-align: middle;
        }

        .pagination {
            display: flex;
            justify-content: left;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
            display: inline-block;
        }

        .pagination li a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #52a6ff;
            color: #000000;
            border: 2px solid #00050a;
            border-radius: 4px;
        }

        .pagination li a:hover {
            background-color: #0056b3;
        }


        .switch {
            position: relative;
            display: inline-block;
            width: 54px;
            height: 28px;
        }

        .tabs-style-3 .nav.panel-tabs li a {
            cursor: pointer;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .table-buttons > a,
        .table-buttons > button,
        .table-buttons > form {
            margin: 2px;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-icon i {
            font-size: 14px;
        }

        .dropdown button.dropdown-item {
            background: transparent;
            border: 0;
            border-bottom: 1px solid #f9f9f9;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .dropdown button.dropdown-item .fa {
            margin-left: 8px;
        }

        .dropdown button.dropdown-item:hover {
            background-color: #ecf0fa;
        }

        table.dataTable thead > tr > th {
            text-align: right;
            padding: 10px 10px 10px 30px;
        }

        .dark-theme .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #fff !important;
        }

        .droos-dropdown-options .dropdown-item {
            display: flex;
            align-items: center;
        }

        .droos-dropdown-options .dropdown-item i {
            margin-left: 6px;
        }


        .svg-loader {
            display: flex;
            position: relative;
            align-content: space-around;
            justify-content: center;
        }

        .loader-svg {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            fill: none;
            stroke-width: 5px;
            stroke-linecap: round;
            stroke: rgb(64, 0, 148);
        }

        .loader-svg.bg {
            stroke-width: 8px;
            stroke: rgb(207, 205, 245);
        }

        .animate {
            stroke-dasharray: 242.6;
            animation: fill-animation 1s cubic-bezier(1, 1, 1, 1) 0s infinite;
        }

        @keyframes fill-animation {
            0% {
                stroke-dasharray: 40 242.6;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 141.3;
                stroke-dashoffset: 141.3;
            }
            100% {
                stroke-dasharray: 40 242.6;
                stroke-dashoffset: 282.6;
            }
        }

        .info-balloon {
            width: 30px;
            height: 30px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            border: 3px solid #eee;
            color: #eee;
            cursor: pointer;
        }

        .static-footer {
            text-align: left;
        }

        .side-menu__item.active .side-menu__icon.solid__icon path,
        .side-menu__item.active .side-menu__icon.solid__icon .colored,
        .slide:hover .side-menu__label, .slide:hover .angle, .slide:hover .side-menu__icon.solid__icon path,
        .slide:hover .side-menu__label, .slide:hover .angle, .slide:hover .side-menu__icon.solid__icon .colored {
            fill: var(--primary-bg-color) !important;
        }

        span.page-link {
            margin-left: 4px !important;
            border-radius: 5px
        }

        .card-header {
            border-bottom: 1px solid #e7e7e7;
        }

        .form-filters {
            display: flex;
        }

        .form-filters .form-inline {
            padding: 5px 20px;
            margin: 5px;
            border-radius: 10px;
            border: 1px solid #e7e7e7;
        }

        .form-filters .form-inline input[type='checkbox'] {
            display: none;
        }

        .form-filters .form-inline,
        .form-filters .form-inline * {
            cursor: pointer;
        }

        .form-filters .form-inline:hover {
            opacity: .7;
        }

        .form-filters .form-inline.active {
            background-color: #3498db;
            color: #ffffff;
            border-color: #2980b9;
        }

        .main-content-title {
            font-weight: 900;;
            color: #4e5381!important
        }

        body:not(.dark-theme)#dvImage::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #e4ebf2;
            z-index: -1;
            /*opacity: .8;*/
            /*filter: blur(15px);*/
        }

        .svg-icon g [fill] {
            -webkit-transition: fill 0.3s ease;
            transition: fill 0.3s ease;
            fill: #b2b2b2 !important;
        }

        .line-through {
            text-decoration: line-through;
            color: red;
        }

        .image-upload-wrapper {
            display: flex;
        }

        .single-image-upload,
        .single-upload-image {
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
        }

        .single-image-upload {
            border: 3px dashed #e7e7e7;
            font-size: 3rem;
            color: #e7e7e7;
        }

        .single-upload-image {
            border: 3px solid #e7e7e7;
            margin-right: 10px;
        }

        .single-image-field {
            width: 0;
            height: 0;
            display: none;
        }

        .table-buttons {
            display: flex;
        }

        #data-table_wrapper {
            overflow-y: hidden;
        }

        .dataTables_info {
            margin-bottom: 1rem;
        }

        .select2-container--default[dir=rtl] .select2-selection--multiple .select2-selection__choice {
            color: #333333;
        }

        body.mobile #booking-details-wrap {
            position: fixed;
            top: -50px;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999999;
            background-color: #fff;
            overflow-x: scroll;
            padding: 0;
        }

        body.mobile #booking-details-wrap > .row {
            padding: 1rem;
        }

        body.mobile #go-back {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 50px;
            border-left: 2px solid #e7e7e7;
            background: transparent;
            border-bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header {
            display: none;
            position: relative;
        }

        body.mobile header {
            display: block;
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
            -webkit-box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
            -moz-box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
            -o-box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
            padding: 1rem;
        }

        body.mobile header h5 {
            color: var(--main-color);
        }

        .data-container-header {
            color: var(--main-color);
        }

        .data-container {
            padding: 1rem;
            border: 1px solid #e7e7e7;
            border-radius: 22px;
            margin-top: .5rem;
        }

        .data-container .container-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 13px 0
        }

        .white-button {
            font-size: 13px;
            padding: 5px 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            color: var(--main-color);
            font-weight: 700;
            box-shadow: rgb(0 0 0 / 24%) 0 3px 8px;
            -webkit-box-shadow: rgb(0 0 0 / 24%) 0 3px 8px;
            -moz-box-shadow: rgb(0 0 0 / 24%) 0 3px 8px;
            -o-box-shadow: rgb(0 0 0 / 24%) 0 3px 8px;
        }

        .white-button.with-icon {
            display: flex;
            align-items: center;
            margin-left: 1rem;
            justify-content: center;
        }

        .white-button.with-icon i {
            font-size: 20px;
            margin: 0 4px;
        }

        .column-value {
            font-family: tahoma, sans-serif;
        }

        .table th, .table td {
            text-align: right;
        }

        .small-input-group input {
            width: 150px;
            display: inline-block;
            padding: 10px;
            margin-left: 10px;
        }

        label.required {
            position: relative;
        }

        label.required::after {
            content: "*";
            color: red;
            position: absolute;
            top: 0;
            left: -10px
        }

        .card-header {
            background-color: #f6f9fc!important
        }

        .card-header h3 {
            font-weight: normal;
            color: #75799d;
        }

        .card-body .table thead th {
            padding: 1rem;
        }
    </style>

    @stack('styles')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</head>

<body id="dvImage" class="hold-transition main-body app sidebar-mini rtl"
      style="background-attachment: fixed;width: 100%;background-image:url('{{asset('assets/images/salon.jpeg')}}');background-size: cover;background-repeat: no-repeat;background-position: center center;min-height: 100vh;margin: 0">

<!-- Loader -->
<div id="global-loader">
    <img src="{{asset('assets/back/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<!-- Page -->
<div class="page custom-index">
    <div>
        <!-- main-header -->
        <div class="main-header side-header sticky nav nav-item">
            <div class="container-fluid main-container ">
                <div class="main-header-left ">
                    <div class="responsive-logo">
                        <a href="{{dashboard_route()}}" class="header-logo">
                            <img src="{{asset('assets/images/brand/mabeet-logo.png')}}" class="logo-1" alt="logo">
                            <img src="{{asset('assets/images/brand/mabeet-logo-horizontal.png')}}" class="dark-logo-1"
                                 alt="logo">
                        </a>
                    </div>

                    <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                        <a class="open-toggle" href="javascript:void(0);"><i
                                class="header-icon fe fe-align-left"></i></a>
                        <a class="close-toggle" href="javascript:void(0);"><i class="header-icons fe fe-x"></i></a>
                    </div>
                </div>

                <div class="main-header-right">
                    <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                            aria-controls="navbarSupportedContent-4" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon fe fe-more-vertical "></span>
                    </button>
                    <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                            <ul class="nav nav-item  navbar-nav-right ms-auto">
                                <li class="dropdown nav-item main-layout">
                                    <a id="change-mood" class="new nav-link theme-layout nav-link-bg layout-setting">
                                        <span class="dark-layout"><svg xmlns="http://www.w3.org/2000/svg"
                                                                       class="header-icon-svgs" width="24" height="24"
                                                                       viewBox="0 0 24 24"><path
                                                    d="M20.742 13.045a8.088 8.088 0 0 1-2.077.271c-2.135 0-4.14-.83-5.646-2.336a8.025 8.025 0 0 1-2.064-7.723A1 1 0 0 0 9.73 2.034a10.014 10.014 0 0 0-4.489 2.582c-3.898 3.898-3.898 10.243 0 14.143a9.937 9.937 0 0 0 7.072 2.93 9.93 9.93 0 0 0 7.07-2.929 10.007 10.007 0 0 0 2.583-4.491 1.001 1.001 0 0 0-1.224-1.224zm-2.772 4.301a7.947 7.947 0 0 1-5.656 2.343 7.953 7.953 0 0 1-5.658-2.344c-3.118-3.119-3.118-8.195 0-11.314a7.923 7.923 0 0 1 2.06-1.483 10.027 10.027 0 0 0 2.89 7.848 9.972 9.972 0 0 0 7.848 2.891 8.036 8.036 0 0 1-1.484 2.059z"/></svg></span>
                                        <span class="light-layout"><svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="header-icon-svgs" width="24" height="24"
                                                                        viewBox="0 0 24 24"><path
                                                    d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19h2v3h-2zm0-17h2v3h-2zm-9 9h3v2h-3zm17 0h3v2h-3zM4.219 18.363l2.12-2.122 1.415 1.414-2.12 2.122zM16.24 6.344l2.122-2.122 1.414 1.414-2.122 2.122zM6.342 7.759 4.22 5.637l1.415-1.414 2.12 2.122zm13.434 10.605-1.414 1.414-2.122-2.122 1.414-1.414z"/></svg></span>
                                    </a>
                                </li>

                                <li class="nav-item full-screen fullscreen-button">
                                    <a class="new nav-link full-screen-link" href="javascript:void(0);">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs feather feather-maximize"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                                        </svg>
                                    </a>
                                </li>

                                <li class="dropdown main-header-message right-toggle">
                                    <a class="nav-link pe-0" data-bs-toggle="sidebar-right"
                                       data-bs-target=".sidebar-right">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="header-icon-svgs feather feather-bell" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                        <span class=" pulse"></span>
                                    </a>
                                </li>

                                <li class="dropdown main-profile-menu nav nav-item nav-link">
                                    <a class="profile-user d-flex" href=""><img alt=""
                                                                                src="{{get_user_image('admin')}}"></a>

                                    <div class="dropdown-menu">
                                        <div class="main-header-profile bg-primary p-3">
                                            <div class="d-flex wd-100p">
                                                <div class="main-img-user"><img alt="" src="{{get_user_image('admin')}}"
                                                                                class=""></div>

                                                <div class="ms-3 my-auto">
                                                    <h6>{{auth('admin')->user()->name}}</h6>
                                                    <span>{{get_user_title()}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <a class="dropdown-item" href="#"><i class="si si-settings"></i> تعديل الملف
                                            الشخصي </a>
                                        <a class="dropdown-item"
                                           onclick="document.getElementById('logout-form').submit()" href="#"><i
                                                class="bx bx-log-out"></i> تسجيل الخروج </a>

                                        <form action="{{route('dashboard.logout')}}" method="POST" id="logout-form"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /main-header -->

        <!-- main-sidebar -->
        <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>

        <div class="sticky">
            <aside class="app-sidebar sidebar-scroll">

                <div class="main-sidebar-header">
                    <a class="desktop-logo logo-light active" href="{{dashboard_route()}}"><img
                            src="{{asset('assets/images/brand/logo-horizontal.png')}}" class="main-logo" alt="logo"></a>
                    <a class="desktop-logo logo-dark active" href="{{dashboard_route()}}"><img
                            src="{{asset('assets/images/brand/logo-horizontal.png')}}" class="main-logo"
                            alt="logo"></a>
                    <a class="logo-icon mobile-logo icon-light active" href="{{dashboard_route()}}"><img
                            src="{{asset('assets/images/brand/favicon.png')}}" alt="logo"></a>
                    <a class="logo-icon mobile-logo icon-dark active" href="{{dashboard_route()}}"><img
                            src="{{asset('assets/images/brand/favicon-white.png')}}" alt="logo"></a>
                </div>

                @include('Admin.Layouts.Sidebar')
            </aside>
        </div>
        <!-- main-sidebar -->
    </div>

    <!-- main-content -->
    <div class="main-content app-content">

        <!-- container -->
        <div class="main-container container-fluid">

            @yield('content')
        </div>
        <!-- /Container -->
    </div>
    <!-- /main-content -->

    <!-- Sidebar-right-->
    <div class="sidebar sidebar-right sidebar-animate">
        <div class="panel panel-primary card mb-0 box-shadow">
            <div class="tab-menu-heading border-0 p-3">
                <div class="card-title mb-0">الإشعارات</div>

                <div class="card-options ms-auto">
                    <a href="javascript:void(0);" class="sidebar-remove"><i class="fe fe-x"></i></a>
                </div>
            </div>
            <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">

                @foreach(auth('admin')->user()->notifications()->get() as $notification)
                    <div class="list d-flex align-items-center border-bottom p-3">
                        <div class="">
                            <span class="avatar bg-primary brround avatar-md">CH</span>
                        </div>
                        <a class="wrapper w-100 ms-3" href="javascript:void(0);">
                            <p class="mb-0 d-flex ">
                                <b>New Websites is Created</b>
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-clock text-muted me-1"></i>
                                    <small class="text-muted ms-auto">30 mins ago</small>
                                    <p class="mb-0"></p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!--/Sidebar-right-->

    <!-- Footer opened -->
    <div class="main-footer ht-45">
        <div class="container-fluid pd-t-0 ht-100p">
            <span> جميع الحقوق محفوظة &copy; {{date('Y')}} <a href="{{url('/')}}" class="text-primary">اتحاد الملاك</a></span>
        </div>
    </div>
    <!-- Footer closed -->

</div>
<!-- End Page -->

<!-- Bootstrap Bundle js -->

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //
    //     var optionsContainer = document.getElementById("options-container");
    //
    //     var addOptionsButton = document.getElementById("add-options-btn");
    //
    //     addOptionsButton.addEventListener("click", function() {
    //
    //         var newOptionInput = document.createElement("input");
    //         newOptionInput.type = "text";
    //         newOptionInput.className = "form-control";
    //         newOptionInput.name = "options[]";
    //         newOptionInput.placeholder = "Option";
    //
    //
    //         optionsContainer.appendChild(newOptionInput);
    //     });
    // });
</script>

<script src="{{asset('assets/back/plugins/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('assets/back/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Moment js -->
<script src="{{asset('assets/back/plugins/moment/moment.js')}}"></script>

<!-- Eva-icons js -->
<script src="{{asset('assets/back/js/eva-icons.min.js')}}"></script>

<!-- right-sidebar js -->
<script src="{{asset('assets/back/plugins/sidebar/sidebar.js')}}"></script>
<script src="{{asset('assets/back/plugins/sidebar/sidebar-custom.js')}}"></script>

<!-- Sticky js -->
<script src="{{asset('assets/back/js/sticky.js')}}"></script>
<script src="{{asset('assets/back/js/modal-popup.js')}}"></script>

<!-- Left-menu js-->
<script src="{{asset('assets/back/plugins/side-menu/sidemenu.js')}}"></script>

<!--Internal  index js -->
<script src="{{asset('assets/back/js/index.js')}}"></script>

<!--themecolor js-->
<script src="{{asset('assets/back/js/themecolor.js')}}"></script>

{{--<script src="{{asset('assets/back/plugins/select2/js/select2.min.js')}}"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- custom js -->
<script src="{{asset('assets/back/js/plugins.js')}}"></script>
<script src="{{asset('assets/back/js/custom.js')}}"></script>

<script>
    // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
    // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    //     return new bootstrap.Tooltip(tooltipTriggerEl)
    // })

    // $(document).load(function (){
    // $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    // })

    toastr.options.progressBar = true
    toastr.options.positionClass = 'toast-bottom-left'

    $(document).ready(function () {
        @include('Messages-toastr')
    })

    $('body').on('click', '.delete', function (e) {
        e.preventDefault();

        const form = $(this).parents('form');

        Swal.fire({
            title: "انت على وشك حذف العنصر",
            text: "هل انت متأكد من حذف العنصر؟",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "حذف العنصر",
            cancelButtonText: "الغاء",
            dangerMode: true,
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        })

    });

    $('#change-mood').on('click', function () {
        const isDark = $('body').hasClass('dark-theme');
        const changeTo = isDark ? '' : 'dark_theme';

        $.post('/change-mood', {changeTo: changeTo})
    });

    function playSound() {
        const audio = new Audio('/files/notification.mp3');
        audio.play();
    }

    $('.form-inline .checkable:checked').each(function (item) {
        $(this).parents('.form-inline').addClass('active')
    });

    $('.form-inline .checkable').on('change', function (e) {
        $(this).parents('.form-inline').toggleClass('active')
    });


    const currentPageUrl = window.location.href;

    const anchor = $('a[href="'+currentPageUrl+'"]');

    anchor.addClass('active').parents('.slide-menu').addClass('.is-expanded').parents('.slide').addClass('is-expanded');

</script>

<script>
    // $(".selectize-single").select2();

    $('.alert-dismissible .close-button').on('click', function (e) {
        e.preventDefault();

        $(this).parents('.alert').fadeOut()
    })

    function showPreview(event, ele) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            let link = document.getElementById(ele + '-link');
            var preview = document.getElementById(ele);
            preview.src = src;
            link.href = src;

            preview.style.display = "block";
        }
    }

    function limitDigits(input, maxLength = 10) {
        const value = input.value;
        console.log(maxLength)
        if (value.length > maxLength) {
            input.value = value.slice(0, maxLength);
        }
    }

    // $('.tooltip-container').tooltip();

</script>

@stack('scripts')

</body>
</html>
