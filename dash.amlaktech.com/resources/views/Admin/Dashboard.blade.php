@extends('Admin.Layouts.Dashboard')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap"
        rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/kpis/index.css')}}"/>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="center-content ">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">أهلاََ
                    وسهلاََ {{dashboard_auth()->user()->name}}</h2>
                {{--                <p class="mg-b-0">لوحة تحكم اتحاد الملاك </p>--}}
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    @include('Frontend.Partials._messages')

    {{--    <div>--}}
    {{--        <strong class="tx-30 text-primary mn-3">الميزانية العامة</strong>--}}
    {{--    </div>--}}

    <div class="row mt-2">
        <div class="col-sm-12 col-lg-6 col-xl-3">
            <div class="card card-img-holder">
                <div class="card-body list-icons">
                    <div class="clearfix">
                        <div class="float-end  mt-2">
                          <span class="text-primary ">
                            {{-- <i class="si si-basket-loaded tx-30"></i> --}}
                              <i class="si si-credit-card tx-30"></i>
                          </span>
                        </div>
                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1"> الاشتراكات</h4>
                            <h3 class="pr-3" id="subscriptionsCounter">{{$subscriptions}}</h3>
                        </div>
                    </div>
                    <a href="{{route('dashboard.subscriptions.index')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-arrow-down-circle text-info me-1-20  me-2"
                                                               aria-hidden="true"></i>عرض الاشتراكات</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 col-xl-3">
            <div class="card card-img-holder">
                <div class="card-body list-icons">

                    <div class="clearfix">

                        <div class="float-end mb-3">
                            <span class="text-success ">
{{--                                {{ currency($paids) }}--}}
                            </span>
                        </div>
                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1">الوحدات</h4>
                            <h3 class="pr-3">{{$paidsCount}}</h3>
                        </div>
                    </div>

                    <a href="{{route('dashboard.subscriptions.paid')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-success me-2"></i>عرض
                                الوحدات</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 col-xl-3">
            <div class="card card-img-holder">
                <div class="card-body list-icons">
                    <div class="clearfix">
                        <div class="float-end  mb-3">
                            <span class="text-warning text-black">
{{--                                {{ currency($notPaids) }}--}}
                            </span>
                        </div>
                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1">طلبات النظام</h4>
                            <h3 class="pr-3">{{$notPaidsCount}}</h3>
                        </div>
                    </div>
                    <a href="{{route('dashboard.subscriptions.notPaid')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-warning me-2"></i>عرض
                                طلبات النظام</p>
                        </div>
                    </a>

                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6 col-xl-3">
            <div class="card card-img-holder">
                <div class="card-body list-icons">
                    <div class="clearfix">
                        <div class="float-left  mb-3">
                            <span class="text-danger">
{{--                                {{ currency($lates) }}--}}
                            </span>
                        </div>

                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1">المتأخرات</h4>
                            <h3 class="pr-3">{{$latesCount}}</h3>
                        </div>
                    </div>

                    <a href="{{route('dashboard.subscriptions.late')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-danger me-2"></i>عرض
                                المتأخرات</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="row row-sm">

        @if(is_admin())
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-order">
                            <h6 class="mb-2">عدد الجمعيات</h6>
                            <h2 class="text-end"><i
                                    class="fe fe-bar-chart-2 tx-40 float-start text-primary text-primary-shadow"></i><span>{{$associations}}</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">الملاك</h6>
                        <h2 class="text-end"><i
                                class="fe fe-users tx-40 float-start text-primary text-primary-shadow"></i><span>{{$members}}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">الوحدات</h6>
                        <h2 class="text-end"><i
                                class="fe fe-home tx-40 float-start text-primary text-primary-shadow"></i><span>{{$units}}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">السندات</h6>
                        <h2 class="text-end"><i
                                class="fe fe-home tx-40 float-start text-primary text-primary-shadow"></i><span>{{$paymentReceipts}}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($getCompanyContracts as $companyContract)
        <div class="card card-dismissable" id="card-company-{{$companyContract->id}}" data-card-id="card-company-{{$companyContract->id}}">

            <!-- Dismiss icon at the top-left corner -->
            <div class="position-absolute top-1 end-0 m-2">
                <button type="button" class="btn-close dismiss" aria-label="Close"></button>
            </div>

            <div class="card-body">
                <h5 class="card-title">التصويت على عقد شركة خدمية</h5>

                <p class="card-text">
                    هناك عقد شركة "{{$companyContract->name}}" لم يتم التصويت عليه فهل انت موافق او غير موافق
                </p>

                <!-- Align buttons to the right with icons -->
                <div class="d-flex">

                    <button id="agreeBtn" data-id="{{$companyContract->id}}" class="btn btn-success agreeBtn">
                        <i class="bi bi-check-circle"></i> آوافق
                    </button> &nbsp;

                    <button id="disagreeBtn" data-id="{{$companyContract->id}}" class="btn btn-danger disagreeBtn">
                        <i class="bi bi-x-circle"></i> لا أوافق
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <div class="charts">
        <div>
            <div class="chart-outer-wrapper">
                <div class="header">
                    <p>اجمالي الوحدات</p>
                    <span>
                  قم بتغير الفترة الزمنية لمقارنة الوحدات في فترات مختلفة
                </span>
                </div>
                <div class="filters">
                    <div class="radio-inputs">
                        <label class="radio">
                            <input
                                type="radio"
                                name="total-sales-filter"
                                value="today"/>
                            <span class="name">يومي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                value="week"
                                name="total-sales-filter"
                                checked=""/>
                            <span class="name">اسبوعي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                value="month"
                                name="total-sales-filter"/>
                            <span class="name">شهري</span>
                        </label>

                        <label class="radio">
                            <input
                                type="radio"
                                value="three_months"
                                name="total-sales-filter"/>
                            <span class="name">ربع سنوي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                value="six_months"
                                name="total-sales-filter"/>
                            <span class="name">نصف سنوي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                value="year"
                                name="total-sales-filter"/>
                            <span class="name">سنوي</span>
                        </label>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart">
                        <canvas id="total-sales-chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div>
            <div class="chart-outer-wrapper">
                <div class="header">
                    <p>اجمالي الاشتراكات</p>
                    <span>
                  قم بتغير الفترة الزمنية لمقارنة الاشتراكات في فترات مختلفة
                </span>
                </div>
                <div class="filters">
                    <div class="radio-inputs">
                        <label class="radio">
                            <input type="radio" name="profits-filter" value="today"/>
                            <span class="name">يومي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                name="profits-filter"
                                checked=""
                                value="week"/>
                            <span class="name">اسبوعي</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="profits-filter" value="month"/>
                            <span class="name">شهري</span>
                        </label>

                        <label class="radio">
                            <input
                                type="radio"
                                name="profits-filter"
                                value="three_months"/>
                            <span class="name">ربع سنوي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                name="profits-filter"
                                value="six-months"/>
                            <span class="name">نصف سنوي</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="profits-filter" value="year"/>
                            <span class="name">سنوي</span>
                        </label>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart">
                        <canvas id="profits-chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div>
            <div class="chart-outer-wrapper">
                <div class="header">
                    <p>الوحدات</p>
                    <span>
                  قم بتغير الفترة الزمنية لمقارنة الوحدات في فترات مختلفة
                </span>
                </div>
                <div class="filters">
                    <div class="radio-inputs">
                        <label class="radio">
                            <input type="radio" name="units-filter" value="today"/>
                            <span class="name">يومي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                name="units-filter"
                                checked=""
                                value="week"/>
                            <span class="name">اسبوعي</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="units-filter" value="month"/>
                            <span class="name">شهري</span>
                        </label>

                        <label class="radio">
                            <input
                                type="radio"
                                name="units-filter"
                                value="three_months"/>
                            <span class="name">ربع سنوي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                name="units-filter"
                                value="six-months"/>
                            <span class="name">نصف سنوي</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="units-filter" value="year"/>
                            <span class="name">سنوي</span>
                        </label>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart">
                        <canvas id="units-chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <!--  -->
        <div>
            <div class="chart-outer-wrapper">
                <div class="header">
                    <p>الحجوزات</p>
                    <span>
                  قم بتغير الفترة الزمنية لمقارنة الحجوزات في فترات مختلفة
                </span>
                </div>
                <div class="filters">
                    <div class="radio-inputs">
                        <label class="radio">
                            <input type="radio" name="bookings-filter" value="today"/>
                            <span class="name">يومي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                name="bookings-filter"
                                checked=""
                                value="week"/>
                            <span class="name">اسبوعي</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="bookings-filter" value="month"/>
                            <span class="name">شهري</span>
                        </label>

                        <label class="radio">
                            <input
                                type="radio"
                                name="bookings-filter"
                                value="three_months"/>
                            <span class="name">ربع سنوي</span>
                        </label>
                        <label class="radio">
                            <input
                                type="radio"
                                name="bookings-filter"
                                value="six-months"/>
                            <span class="name">نصف سنوي</span>
                        </label>
                        <label class="radio">
                            <input type="radio" name="bookings-filter" value="year"/>
                            <span class="name">سنوي</span>
                        </label>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart">
                        <canvas id="bookings-chart" role="img"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('assets/kpis/index.js')}}"></script>

    <script>

        // Check sessionStorage for dismissed cards
        $('.card-dismissable').each(function() {
            const cardId = $(this).data('card-id');

            if (sessionStorage.getItem('dismissedCard-' + cardId)) {
                $(this).hide(); // Hide if previously dismissed
            }
        });

        // Handler for the Agree button
        $('.agreeBtn').click(function () {
            let confirmed = confirm("هل انت متأكد من التصويت بالموافقه على العقد؟");
            const Id = $(this).data('id');
            const card = $(this).parents('.card');

            if (confirmed) {
                sendData(card, Id, 'agree');
            }
        });

        // Handler for the Disagree button
        $('.disagreeBtn').click(function () {
            let confirmed = confirm("هل انت متأكد من التصويت بعدم الموافقة على العقد؟");
            const Id = $(this).data('id');
            const card = $(this).parents('.card');

            if (confirmed) {
                sendData(card, Id, 'disagree');
            }
        });

        // Function to send AJAX request
        function sendData(card, Id, vote) {
            let url = "{{dashboard_route('companies.agreements.vote', ':id')}}";
            url = url.replace(':id', Id)

            $.ajax({
                url: url,  // Change to your Laravel route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Include CSRF token for Laravel
                    vote: vote
                },
                success: function (data) {
                    card.hide(500);
                    toastr.success(data.data[0])
                },
                error: function (err) {
                    toastr.error(err.data)
                }
            });
        }

        $('.btn-close').on('click', function (){
            const card = $(this).parents('.card');

            const cardId = card.data('card-id');

            card.hide(500); // Hide the card with animation
            sessionStorage.setItem('dismissedCard-' + cardId, true); // Store dismissal in sessionStorage
        })
    </script>
@endpush
