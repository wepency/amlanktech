@extends('Admin.Layouts.Dashboard')

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
                            <h3 class="pr-3" id="subscriptionsCounter">0</h3>
                        </div>
                    </div>
                    <a href="{{route('dashboard.subscriptions.index')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-arrow-down-circle text-info me-1-20  me-2"
                                                               aria-hidden="true"></i>الاطلاع</p>
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
                            <span class="text-success ">
                                {{ currency($paids) }}
                            </span>
                        </div>
                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1">المدفوعات</h4>
                            <h3 class="pr-3">{{$paidsCount}}</h3>
                        </div>
                    </div>

                    <a href="{{route('dashboard.subscriptions.paid')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-success me-2"></i>الاطلاع
                            </p>
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
                                {{ currency($notPaids) }}
                            </span>
                        </div>
                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1">المستحقات</h4>
                            <h3 class="pr-3">{{$notPaidsCount}}</h3>
                        </div>
                    </div>
                    <a href="{{route('dashboard.subscriptions.notPaid')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-warning me-2"></i>الاطلاع
                            </p>
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
                                {{ currency($lates) }}
                            </span>
                        </div>

                        <div class="float-start">
                            <h4 class="card-text text-muted mb-1">المتأخرات</h4>
                            <h3 class="pr-3">{{$latesCount}}</h3>
                        </div>
                    </div>

                    <a href="{{route('dashboard.subscriptions.late')}}">
                        <div class="card-footer p-0">
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-danger me-2"></i>الاطلاع
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">عدد الجمعيات</h6>
                        <h2 class="text-end"><i class="fe fe-bar-chart-2 tx-40 float-start text-primary text-primary-shadow"></i><span>1896</span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">الملاك</h6>
                        <h2 class="text-end"><i class="fe fe-users tx-40 float-start text-primary text-primary-shadow"></i><span>1896</span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">الوحدات</h6>
                        <h2 class="text-end"><i class="fe fe-home tx-40 float-start text-primary text-primary-shadow"></i><span>1896</span></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-order">
                        <h6 class="mb-2">السندات</h6>
                        <h2 class="text-end"><i class="fe fe-home tx-40 float-start text-primary text-primary-shadow"></i><span>1896</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('assets/back/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('assets/back/plugins/morris.js/morris.min.js')}}"></script>


    <script>
        // Define target values for the counters
        const targetSubscriptions = {{$subscriptions}};
        const targetPaid = {{$paids}};
        const targetNotPaid = {{$notPaids}};
        const targetLate = {{$lates}};
        const targetAssociations = {{$associations}};
        const targetMembers = {{$members}};
        const targetUnits = {{$units}};
        const targetBills = {{$bills}};

        const counters = {
            subscriptions: {elementId: 'subscriptionsCounter', targetValue: targetSubscriptions},
            paid: {elementId: 'paidCounter', targetValue: targetPaid},
            notPaid: {elementId: 'notPaidCounter', targetValue: targetNotPaid},
            late: {elementId: 'lateCounter', targetValue: targetLate},
            associations: {elementId: 'associations', targetValue: targetAssociations},
            members: {elementId: 'members', targetValue: targetMembers},
            units: {elementId: 'units', targetValue: targetUnits},
            bills: {elementId: 'bills', targetValue: targetBills},
        };

        // Function to update a counter
        function updateCounter(counter) {
            const element = document.getElementById(counter.elementId);
            const duration = 1000; // Duration in milliseconds
            const frameDuration = 1000 / 60; // 60 frames per second

            const increment = counter.targetValue / (duration / frameDuration);
            let currentCount = 0;

            const counterInterval = setInterval(() => {
                currentCount += increment;
                element.textContent = Math.round(currentCount);

                if (currentCount >= counter.targetValue) {
                    element.textContent = counter.targetValue;
                    clearInterval(counterInterval);
                }
            }, frameDuration);
        }

        // Start the counter animations for each category
        for (const key in counters) {
            if (Object.hasOwnProperty.call(counters, key)) {
                const counter = counters[key];
                updateCounter(counter);
            }
        }
    </script>

@endsection
