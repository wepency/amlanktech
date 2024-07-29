<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Title -->
    <title>{{isset($page_title) ? $page_title : ''}} | لوحة تحكم {{config('app.name')}} </title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="{{asset('assets/back/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- style css -->
{{--    <link href="{{asset('assets/back/css/style.css')}}" rel="stylesheet">--}}

    <style>
        body *{
            font-family: 'Cairo', sans-serif;
        }

        .form-control{
            padding: 15px !important;
            background-color: #f9f9f9 !important;
        }
    </style>
</head>

<body class="rtl error-page1 main-body bg-light text-dark error-3">

<!-- Loader -->
<div id="global-loader">
    <img src="{{asset('assets/back/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->

<!-- Page -->
<div class="page">
    <div class="main-container container-fluid">
        <div class="row no-gutter">
            <div class="col-md-6 offset-md-3 bg-white py-4">
                <div class="login d-flex align-items-center py-2">
                    <!-- Demo content-->
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                <div class="card-sigin">
                                    <div class="text-center">
                                        <a href="{{url('/')}}">
                                            <img style="height: 50px;margin-bottom: 20px" src="{{asset('assets/images/brand/elqima-logo.png')}}" class="sign-favicon-a" alt="logo">
                                        </a>
                                    </div>

                                    <div class="card-sigin">
                                        <div class="main-signup-header">
                                            <h2 class="text-center">أهلا بكم في لوحة تحكم القمة</h2>
                                            <h5 class="fw-semibold text-center mb-4">برجاء تسجيل الدخول للدخول الى لوحة التحكم</h5>

                                            @include('messages')

                                            @yield('content')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End -->
                </div>
            </div><!-- End -->
        </div>
    </div>

</div>
<!-- End Page -->

<!-- JQuery min js -->
<script src="{{asset('assets/back/plugins/jquery/jquery.min.js')}}"></script>

<!-- custom js -->
<script src="{{asset('assets/back/js/custom.js')}}"></script>

</body>

</html>
