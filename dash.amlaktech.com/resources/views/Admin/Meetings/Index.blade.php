@extends('Admin.Layouts.Dashboard')

@push('styles')
    <!-- Include Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="modal fade" id="add-edit-meetings" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Agenda Modal -->
    <div class="modal fade" id="agenda-modal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Decisions Modal -->
    <div class="modal fade" id="decisions-modal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Meeting User Logs Modal -->
    <div class="modal fade" id="user-logs-modal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">سجل حضور الأعضاء</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{asset('assets/images/empty-result_shot.svg')}}" class="img-fluid" alt="empty">
                        <h3 class="mt-2"><strong>لا يوجد بيانات بعد</strong></h3>
                        <h5 class="mt-2 text-muted">البيانات ستظهر مع بدء الاجتماع ودخول المستخدمين.</h5>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">

            {{-- @if (can('add bill')) --}}
            <button type="button" data-bs-toggle="modal"
                    data-bs-target="#add-edit-meetings" id="add-meeting-btn"
                    class="btn btn-danger btn-icon mb-1 me-1">
                <i class="mdi mdi-plus"></i>
            </button>
            {{-- @endif --}}

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الاجتماعات</span>
                <span class="badge  bg-white ms-1">{{$meetings->count()}}</span>
            </span>
        </div>
    </div>
    <!-- breadcrumb -->


    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body">

                    @if(!count($meetings))
                        @include('Admin.Layouts.Partials._empty')
                    @else
                        @include('Admin.Meetings._table')
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@push('scripts')

    <!-- Include Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <script>
        const AddMeetingsBtn = $('#add-meeting-btn');
        const EditMeetingsBtn = $('.edit-meeting-btn');
        const AddEditMeetingsModal = $('#add-edit-meetings');

        const EditAgendaBtn = '.edit-agenda-btn';
        const EditAgendaModal = $('#agenda-modal');

        const EditDecisionsBtn = '.edit-decisions-btn';
        const EditDecisionsModal = $('#decisions-modal');

        AddMeetingsBtn.on('click', function (e) {
            e.preventDefault();
            AddEditMeetingsModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('meetings.create')}}').done(function (data) {
                AddEditMeetingsModal.find('.modal-dialog').html(data.data);
            });
        });

        EditMeetingsBtn.on('click', function (e) {
            e.preventDefault();
            AddEditMeetingsModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('meetings.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditMeetingsModal.find('.modal-dialog').html(data.data);
            });
        });

        $('body').on('click', EditAgendaBtn, function (e) {

            e.preventDefault();
            EditAgendaModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('meetings.agenda.modal', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                EditAgendaModal.find('.modal-dialog').html(data.data);
            });

        })

        $('body').on('click', EditDecisionsBtn, function (e) {

            e.preventDefault();
            EditDecisionsModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('meetings.decisions.modal', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                EditDecisionsModal.find('.modal-dialog').html(data.data);
            });

        })
    </script>
@endpush


