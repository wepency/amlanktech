@extends('Frontend.Layouts.Front-pages')

@section('title', 'تذاكر الدعم')

@push('styles')
    <!-- Include Summernote CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

                <!-- BEGIN NAV TICKET -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header bg-primary text-white">{{$page_title}}</div>

                        <div class="card-body">
                            @include('Frontend.Tickets._form')
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <!-- Include Summernote JS -->
    <script src="{{asset('js/summernote-bs4.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#body').summernote({
                placeholder: 'برجاء ادخال نص التذكرة',
                height: 200, // Set your preferred height,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']],
                    ['view', ['undo', 'redo']],
                ],
            });
        });
    </script>
@endpush
