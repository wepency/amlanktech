@extends('Admin.Layouts.Dashboard')

@push('styles')
    <!-- Include Summernote CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css"
          integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        .card-header:not(.note-toolbar) {
            background-color: #1062fe !important;
        }

        .ticket-details-card .card-body {
            padding: 0;
        }

        .ticket-details-card ul {
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .ticket-details-card ul li {
            padding: 15px;
            border-bottom: 1px solid #e7e7e7;
        }

        .card-header {
            padding: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route('tickets.index')}}">التذاكر /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">

            @if(!in_array($ticket->status, ['closed', 'solved']))
                <form action="{{dashboard_route('tickets.change_status', [$ticket->id, 'solved'])}}" method="POST">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="btn btn-success mb-1 me-1"><i class="fas fa-check-circle"></i> تم الحل
                    </button>
                </form>
            @endif

            @if($ticket->status !== 'closed')
                    <form action="{{dashboard_route('tickets.change_status', [$ticket->id, 'close'])}}" method="POST">
                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-secondary mb-1"><i class="fas fa-comment-slash"></i>اغلاق التذكرة
                        </button>
                    </form>
            @endif

        </div>

    </div>

    <div class="row">

        <div class="col-md-4 col-sm-12">

            <div class="card ticket-details-card">

                <div class="card-header bg-primary text-white">معلومات التذكرة</div>

                <div class="card-body">
                    <ul>
                        <li>
                            <label for="member">صاحب التذكرة</label>
                            <h5>{{$ticket->member->name}}</h5>
                        </li>

                        <li>
                            <label for="association">الجمعية</label>
                            <h5>{{$ticket?->association?->name ?? '--'}}</h5>
                        </li>

                        @if($ticket->created_at)
                            @php
                                $created_at = $ticket->created_at;
                            @endphp

                            <li>
                                <label for="created_at">تاريخ انشاء التذكرة</label>
                                <h5>{{$created_at->format('D, M d, Y') . " ({$created_at->format('H:i')})"}}</h5>
                            </li>
                        @endif

                        @if($ticket->updated_at)
                            @php
                                $updated_at = $ticket->updated_at;
                            @endphp

                            <li>
                                <label for="created_at">أخر تحديث</label>
                                <h5>{{$updated_at->diffForHumans(now())}}</h5>
                            </li>
                        @endif

                        <li>
                            <label for="created_at">تصنيف التذكرة</label>

                            @if($ticket?->category?->name)
                                <h5><span class="badge bg-success">{{$ticket?->category?->name}}</span></h5>
                            @else
                                <h5>--</h5>
                            @endif
                        </li>

                        <li>
                            <label for="association">حالة التذكرة</label>
                            <?php $status = \App\Services\TicketService::checkStatus($ticket->status, $ticket->lastMessage) ?>


                            <h5>
                                <span class="badge bg-{{$status['color_type']}}">{{$status['text']}}</span>
                            </h5>
                        </li>

                    </ul>
                </div>

            </div>

        </div>

        <div class="col-md-8 col-sm-12">

            <div class="card">
                <div class="card-header bg-primary text-white p-2" id="foldableCardHeader">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white d-block w-100 text-right" data-bs-toggle="collapse"
                                data-bs-target="#foldableCardBody" aria-expanded="false"
                                aria-controls="foldableCardBody">

                            اضافة رد للتذكرة

                        </button>
                    </h5>
                </div>

                <div id="foldableCardBody" class="collapse">
                    <div class="card-body">
                        @include('Admin.Tickets._form')
                    </div>
                </div>
            </div>

            @if(!is_null($messages))

                @php
                    $messagesCount = $messages->count();
                @endphp

                @foreach($messages as $message)

                    <div class="card">

                        <div class="card-header bg-primary text-white">
                            <p class="m-0"><i class="fa fa-user"></i> {{$message?->sender?->name ?? ''}}
                                - {{"رد #".($messagesCount + 1 - $loop->iteration)}}</p>
                            <span class="badge bg-white">{{getUserTitle($message?->sender?->role)}}</span>
                        </div>

                        <div class="card-body">

                            @if($message->created_at)
                                <p class="m-0 text-left" style="direction: ltr"><i
                                        class="fa fa-calendar text-success"></i>
                                    <span>{{$message->created_at->format('l, M d, Y')}}</span> <span><i
                                            class="fa fa-clock text-success"></i> {{$message->created_at->format('H:i')}}</span>
                                </p>
                            @endif

                            <p class="m-0 text-right">{!! $message->body !!}</p>

{{--                            {{$message->attachment}}--}}

                            @if($message->stars)
                                <div class="stars-wrapper text-center">
                                    @for($i = 0; $i < $message->stars; $i++)
                                        <i class="fa fa-star text-warning"></i>
                                    @endfor

                                    @for($i = 0; $i < 5 - $message->stars; $i++)
                                        <i class="fa fa-star-o text-warning"></i>
                                    @endfor
                                </div>
                            @endif
                        </div>

                    </div>

                @endforeach

            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <!-- Include Summernote JS -->
    <script src="{{asset('js/summernote-bs4.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('#body').summernote({
                placeholder: 'برجاء ادخال الرد',
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
