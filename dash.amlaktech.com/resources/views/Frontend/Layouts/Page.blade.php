<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/index.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-rkAqeFxYv0ks3s3wWLRSI5KK9trq3fyZV+ejj+ULeFhNPa27F0lIHENlX3+ybyi2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>أملاك-تك</title>

</head>

<body>
<header>
    <a href="{{url('/about-us')}}">
        <img src="/assets/images/logo.png" width="150px" height="70px" alt="Cirkle">
    </a>

    <nav class="navigation">
        <a href="{{url('about-us')}}">الرئيسية</a>
        <a href="{{url('subscriptions')}}">الباقات</a>
        <a href="{{url('services')}}">خدماتنا</a>
        <a href="{{url('services')}}">تواصل معنا</a>
    </nav>
</header>

<section class="main">
    <div>
        <h1>@yield('page_title')</h1>
    </div>
</section>

@yield('content')

<footer class="footer">
    <section class="card-address" id="services">
        <div class="content-address">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="address">
                        <div class="address-icon">
                            <i class="fa-solid fa-address-book"></i>
                        </div>

                        <div class="info-address">
                            <h3> العنوان</h3>
                            <p>
                                3540 الامير خالد بن بندر بن عبدالعزيز حي العارض 6401
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="address">
                        <div class="address-icon">
                            <i class="fa-solid fa-address-book"></i>
                        </div>

                        <div class="info-address">
                            <h3> الاستفسارات العامة</h3>
                            <p>

                                البريد الالكتروني:
                                <br>
                                info@tech-spectrum.com.sa

                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="address">
                        <div class="address-icon">
                            <i class="fas fa-clock"></i>
                        </div>

                        <div class="info-address">
                            <h3> ساعات العمل</h3>
                            <p>

                                ساعات العمل
                                <br>
                                ، 9:00 حتي 17:00

                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <p>

        <a href="http://127.0.0.1:8000/about-us" class="">
            <img src="/assets/images/logo.png" alt="" style="
    width: 190px;
">
        </a>
    </p>
    <p class="footer-title">جميع الحقوق محفوظة @ <span>أتحاد ملاك  </span></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@stack('scripts')

</body>

</html>
