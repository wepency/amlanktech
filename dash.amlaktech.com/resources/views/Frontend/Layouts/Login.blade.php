<!DOCTYPE html>
<html class="no-js" lang="ar" dir="rtl">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="media/favicon.png"/>

    <link rel="stylesheet" href="{{asset('css/bootstrap-rtl.css')}}">
    <link rel="stylesheet" href="{{asset('icofont/icofont.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('css/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/sal.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}" type="text/css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&family=Tajawal:wght@400;800&display=swap"
          rel="stylesheet">

    @stack('styles')
</head>

<body class="sticky-header">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->
<a href="#wrapper" data-type="section-switch" class="scrollup">
    <i class="icofont-bubble-up"></i>
</a>

<!-- Preloader Start Here -->
{{--<div id="preloader"></div>--}}
<div id="wrapper" class="wrapper overflow-hidden">
    <div id="header-search" class="header-search">
        <button type="button" class="close">×</button>
        <form class="header-search-form">
            <input type="search" value="" placeholder="Search here..."/>
            <button type="submit" class="search-btn">
                <i class="flaticon-search"></i>
            </button>
        </form>
    </div>

    @yield('content')
</div>

<!-- Jquery Js -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('js/slick.min.js')}}"></script>
<script src="{{asset('js/sal.js')}}"></script>
<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('js/validator.min.js')}}"></script>
<script src="{{asset('js/select2.min.js')}}"></script>

{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtmXSwv4YmAKtcZyyad9W7D4AC08z0Rb4"></script>--}}

<!-- Site Scripts -->
<script src="{{asset('js/app.js')}}"></script>

@stack('scripts')

</body>
</html>
