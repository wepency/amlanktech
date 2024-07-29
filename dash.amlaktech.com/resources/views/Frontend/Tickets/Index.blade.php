@extends('Frontend.Layouts.Front-pages')

@section('title', 'تذاكر الدعم')

@push('styles')

@endpush

@section('content')

    <div class="container">

        <section class="content">

            <div class="newsfeed-banner">
                <div class="media">
                    <div class="item-icon">
                        <i class="icofont-list"></i>
                    </div>

                    <div class="media-body">
                        <h3 class="item-title">تذاكر الدعم</h3>
                        <p>تذاكر الدعم الخاصة بكم تصل لمدير الجمعية.</p>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- BEGIN NAV TICKET -->
                <div class="col-md-3">
                    @include('Frontend.Tickets._labels')
                </div>

                <!-- END NAV TICKET -->
                <!-- BEGIN TICKET -->
                <div class="col-md-9">


                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between">

                            <span class="text">تذاكر الدعم</span>

                            <!-- BEGIN NEW TICKET -->
                            <a href="{{url('tickets/create')}}" class="btn btn-danger">
                                <i class="fa fa-plus-circle"></i>
                                <span class="text">أضف تذكرة جديدة</span>
                            </a>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- BEGIN TICKET CONTENT -->
                                <div class="col-md-12">
                                    @if(count($tickets))
                                        @include('Frontend.Tickets._table')
                                    @else
                                        @include('Frontend.Partials._empty', ['text' => 'لا يوجد تذاكر بعد'])
                                    @endif
                                </div>
                                <!-- END TICKET CONTENT -->
                            </div>
                        </div>

                    </div>
                </div>
                <!-- END TICKET -->
            </div>
        </section>
    </div>

@endsection
