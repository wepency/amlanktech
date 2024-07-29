<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'موقع اتحاد الملاك')</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="media/favicon.png">

    {{--    <link rel="stylesheet" href="/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="/css/bootstrap-rtl.css">
    <link rel="stylesheet" href="/icofont/icofont.min.css">
    <link rel="stylesheet" href="/css/slick.css">
    <link rel="stylesheet" href="/css/slick-theme.css">
    <link rel="stylesheet" href="/css/magnific-popup.css">
    <link rel="stylesheet" href="/css/sal.css" type="text/css">
    <link rel="stylesheet" href="/css/select2.min.css" type="text/css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="/css/app.css">

    @stack('styles')

</head>

<body class="bg-link-water">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<a href="#wrapper" data-type="section-switch" class="scrollup">
    <i class="icofont-bubble-up"></i>
</a>
<!-- Preloader Start Here -->
<div id="preloader"></div>
<!-- Preloader End Here -->

<div id="wrapper" class="wrapper">
    <!-- Top Header -->
    <header class="fixed-header">
        <div class="header-menu">
            <div class="navbar">
                <div class="nav-item d-none d-sm-block">
                    <div class="header-logo">
                        <a href="{{url('/')}}">
                            <img src="/assets/images/logo.png" alt="Cirkle">
                        </a>
                    </div>
                </div>
                <div class="nav-item nav-top-menu">
                    <nav id="dropdown" class="template-main-menu">
                        <ul class="menu-content">

                            <li class="header-nav-item">
                                <a href="{{url('/')}}" class="menu-link active">الرئيسية</a>
                            </li>

                            <li class="header-nav-item">
                                <a href="{{url('/units')}}" class="menu-link active">الوحدات</a>
                            </li>

                            <li class="header-nav-item">
                                <a href="{{url('/ads')}}" class="menu-link active">الاعلانات</a>
                            </li>

                        </ul>
                    </nav>
                </div>
                <div class="nav-item header-control">
                    <div class="inline-item d-flex align-items-center">

                        <div class="dropdown dropdown-friend">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="icofont-users-alt-4"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">

                                <div class="item-heading">
                                    <h6 class="heading-title">الجمعيات</h6>
                                </div>

                                <div class="item-body">
                                    <div class="media">
                                        <div class="item-img">
                                            <img src="media/figure/chat_5.jpg" alt="Notify">
                                            <span class="chat-status offline"></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="item-title"><a href="#">Lily Zaman</a></h6>
                                            <p>4 in mutual friends</p>
                                            <div class="btn-area">
                                                <a href="#" class="item-btn"><i class="icofont-plus"></i></a>
                                                <a href="#" class="item-btn"><i class="icofont-minus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="item-img">
                                            <img src="media/figure/chat_1.jpg" alt="Notify">
                                            <span class="chat-status online"></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="item-title"><a href="#">Ketty Rose</a></h6>
                                            <p>3 in mutual friends</p>
                                            <div class="btn-area">
                                                <a href="#" class="item-btn"><i class="icofont-plus"></i></a>
                                                <a href="#" class="item-btn"><i class="icofont-minus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="item-img">
                                            <img src="media/figure/chat_8.jpg" alt="Notify">
                                            <span class="chat-status online"></span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="item-title"><a href="#">Rustom vai</a></h6>
                                            <p>6 in mutual friends</p>
                                            <div class="btn-area">
                                                <a href="#" class="item-btn"><i class="icofont-plus"></i></a>
                                                <a href="#" class="item-btn"><i class="icofont-minus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="item-footer">--}}
{{--                                    <a href="#" class="view-btn">View All Friend Request</a>--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        <div class="dropdown dropdown-message">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="icofont-speech-comments"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="item-heading">
                                    <h6 class="heading-title">تذاكر الدعم</h6>
                                </div>

                                <div class="item-body">
                                    <a href="#" class="media">
                                        <div class="item-img">
                                            <img src="/media/figure/notifiy_1.png" alt="Notify">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="item-title">Diana Jameson</h6>
                                            <div class="item-time">15 mins ago</div>
                                            <p>when are nknowen printer took galley of types ...</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="item-footer">
                                    <a href="{{url('/tickets')}}" class="view-btn">عرض كافة تذاكر الدعم</a>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown dropdown-notification">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="icofont-notification"></i><span class="notify-count">3</span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="item-heading">
                                    <h6 class="heading-title">الاشعارات</h6>
                                </div>

                                <div class="item-body">
                                    <a href="#" class="media">
                                        <div class="item-img">
                                            <img src="media/figure/notifiy_1.png" alt="Notify">
                                        </div>

                                        <div class="media-body">
                                            <h6 class="item-title">Diana Jameson</h6>
                                            <div class="item-time">15 mins ago</div>
                                            <p>when are nknowen printer took galley of types ...</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="item-footer">
                                    <a href="#" class="view-btn">عرض كافة الاشعارات</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="inline-item">
                        <div class="dropdown dropdown-admin">
                            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    <span class="media">
                                        <span class="item-img">
                                            <img src="{{get_user_avatar(auth('member')->user()->name)}}" style="width: 44px" alt="Chat">
                                            <span class="acc-verified"><i class="icofont-check"></i></span>
                                        </span>
                                        <span class="media-body">
                                            <span class="item-title">{{auth('member')->user()->name}}</span>
                                        </span>
                                    </span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="admin-options">
                                    <li><a href="#">بيانات الملف الشخصي</a></li>
                                    <li><a href="{{url('/units')}}">وحداتي</a></li>
                                    <li><a href="{{url('/associations')}}">الجمعيات</a></li>
                                    <li><a href="{{url('/')}}">الموظفين</a></li>

                                    <li><a href="#" onclick="document.getElementById('logout-form').submit()">تسجيل الخروج</a></li>
                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Left -->
    <div class="fixed-sidebar">
        <div class="fixed-sidebar-left small-sidebar">
            <div class="sidebar-toggle">
                <button class="toggle-btn toggler-open">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="sidebar-menu-wrap">
                <div class="mCustomScrollbar" data-mcs-theme="dark" data-mcs-axis="y">
                    <ul class="side-menu">
                        <li><a href="{{url('/')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title=" المنشورات"><i class="icofont-newspaper"></i></a></li>
                        <li><a href="{{url('/associations')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title="الجمعيات"><i class="icofont-list"></i></a></li>
                        <li><a href="{{url('/units')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title="الوحدات"><i class="icofont-users-alt-2"></i></a></li>
                        <li><a href="{{url('/meetings')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title="الاجتماعات"><i class="icofont-users-alt-4"></i></a></li>
                        <li><a href="{{url('/ads')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title="الاعلانات"><i class="icofont-photobucket"></i></a></li>
                        <li><a href="{{url('/payments')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title="المدفوعات"><i class="icofont-calendar"></i></a></li>
                        <li><a href="{{url('/tickets')}}" class="menu-link" data-toggle="tooltip" data-placement="right" title="الدعم الفني"><i class="icofont-ui-text-chat"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="fixed-sidebar-left large-sidebar">
            <div class="sidebar-toggle">
                <div class="sidebar-logo">
                    <a href="{{url('/')}}"><img style="max-width: 160px" src="/assets/images/logo.png" alt="Logo"></a>
                </div>

                <button class="toggle-btn toggler-close">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="sidebar-menu-wrap">
                <div class="mCustomScrollbar" data-mcs-theme="dark" data-mcs-axis="y">
                    <ul class="side-menu">
                        <li><a href="{{url('/')}}" class="menu-link"><i class="icofont-newspaper"></i><span class="menu-title">المنشورات</span></a></li>
                        <li><a href="{{url('/associations')}}" class="menu-link"><i class="icofont-list"></i><span class="menu-title">الجمعيات</span></a></li>
                        <li><a href="{{url('/units')}}" class="menu-link"><i class="icofont-users-alt-2"></i><span class="menu-title">الوحدات</span></a></li>
                        <li><a href="{{url('/meetings')}}" class="menu-link"><i class="icofont-users-alt-4"></i><span class="menu-title">الاجتماعات</span></a></li>
                        <li><a href="{{url('/ads')}}" class="menu-link"><i class="icofont-photobucket"></i><span class="menu-title">الاعلانات</span></a></li>
                        <li><a href="{{url('/payments')}}" class="menu-link"><i class="icofont-calendar"></i><span class="menu-title">المدفوعات</span></a></li>
                        <li><a href="{{url('/tickets')}}" class="menu-link"><i class="icofont-ui-text-chat"></i><span class="menu-title">الدعم الفني</span></a></li>
                    </ul>

                    <ul class="top-menu-mobile">
                        <li class="menu-label">Community</li>
                        <li>
                            <a href="user-about.html" class="menu-link">Profile About</a>
                        </li>
                        <li>
                            <a href="user-badges.html" class="menu-link">Profile Badges</a>
                        </li>
                        <li>
                            <a href="forums.html" class="menu-link">Forums</a>
                        </li>
                        <li>
                            <a href="forums-forum.html" class="menu-link">Forums Topic</a>
                        </li>
                        <li>
                            <a href="forums-info.html" class="menu-link">Forums Info</a>
                        </li>
                        <li>
                            <a href="forums-members.html" class="menu-link">Forums Members</a>
                        </li>
                        <li>
                            <a href="forums-media.html" class="menu-link">Forums Media</a>
                        </li>
                        <li class="menu-label">Pages</li>
                        <li>
                            <a href="about-us.html" class="menu-link">About</a>
                        </li>
                        <li>
                            <a href="user-blog.html" class="menu-link">Blog</a>
                        </li>
                        <li>
                            <a href="shop.html" class="menu-link">Shop</a>
                        </li>
                        <li>
                            <a href="single-blog.html" class="menu-link">Blog Details</a>
                        </li>
                        <li>
                            <a href="single-shop.html" class="menu-link">Shop Details</a>
                        </li>
                        <li>
                            <a href="contact.html" class="menu-link">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        @yield('content')
    </div>

    <footer class="mt-5 text-center bg-white p-3">
        <p class="m-0">جميع الحقوق محفوظة &copy; {{date('Y')}}</p>
    </footer>

</div>

<!-- Jquery Js -->
<script src="/js/jquery.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/imagesloaded.pkgd.min.js"></script>
<script src="/js/isotope.pkgd.min.js"></script>
<script src="/js/slick.min.js"></script>
<script src="/js/sal.js"></script>
<script src="/js/jquery.magnific-popup.min.js"></script>
<script src="{{asset('js/validator.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtmXSwv4YmAKtcZyyad9W7D4AC08z0Rb4"></script>--}}

<!-- Site Scripts -->
<script src="/js/app.js"></script>

@stack('scripts')

</body>

</html>
