@extends('Frontend.Layouts.Page')

@section('page_title', $page_title)

@section('content')
    <section class="cards subscriptions" id="subscriptions">

        <div class="content-service mt-5">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <img src="{{asset('assets/images/web-home-02.png')}}" alt="" />
                </div>

                <div class="col-md-6 col-sm-12">
                    <h3>وثّق عقودك مع اتحاد الملاك</h3>

                    <h6>
                        اول منصه لتنظيم اتحادات الملاك ، حيث نسعى لتوفير وسيله سهله ومبسطه لادارة الجمعيه والملاك وتوفير الخدمات اللازمه بكل سهوله.
                    </h6>

                </div>
            </div>

        </div>
    </section>
@endsection
