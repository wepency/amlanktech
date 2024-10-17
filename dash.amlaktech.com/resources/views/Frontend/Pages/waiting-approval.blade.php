@extends('Frontend.Layouts.Login')

@section('title', 'تسجيل الدخول | أملاك-تك')

@section('content')
    <div class="login-page-wrap">
        <div class="content-wrap">
            <div class="login-content">

                <div class="item-logo">
                    <a href="{{url('/')}}"><img src="/assets/images/logo.png" style="max-width: 250px" alt="logo"></a>
                </div>

                <div class="alert alert-warning">
                    <p class="m-0">يتم الان مراجعة طلبك، عند قبول مدير الجمعية الطلب يمكنك الدخول الى الحساب.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
