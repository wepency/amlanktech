@extends('Frontend.Layouts.Front-pages')

@section('title', $page_title)

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
                    @include('Frontend.Tickets._ticket-info')
                    @include('Frontend.Tickets._labels')
                </div>

                <!-- END NAV TICKET -->
                <!-- BEGIN TICKET -->
                <div class="col-md-9">


                    <div class="card">

                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <span class="text"></span>
                        </div>

                        <div class="card-body">

                        </div>

                    </div>
                </div>
                <!-- END TICKET -->
            </div>
        </section>
    </div>

@endsection
