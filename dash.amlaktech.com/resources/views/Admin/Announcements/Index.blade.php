@extends('Admin.Layouts.Dashboard')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')

<div class="modal fade" id="add-edit-announcements" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
    <div class="modal-dialog"></div>
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
                data-bs-target="#add-edit-announcements" id="add-announcement-btn"
                class="btn btn-danger btn-icon mb-1 me-1">
                <i class="mdi mdi-plus"></i>
            </button>
            {{-- @endif --}}

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الاعلانات</span>
                <span class="badge  bg-white ms-1">{{$announcements->count()}}</span>
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

                    @if(!$announcements->count())
                        @include('Admin.Layouts.Partials._empty')
                    @else
                        @include('Admin.Announcements._table')
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>

        const AddAnnouncementsBtn = $('#add-announcement-btn');
        const EditAnnouncementsBtn = $('.edit-announcement-btn');
        const AddEditAnnouncementsModal = $('#add-edit-announcements');

        AddAnnouncementsBtn.on('click', function (e) {
            e.preventDefault();
            AddEditAnnouncementsModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('announcements.create')}}').done(function (data) {
                AddEditAnnouncementsModal.find('.modal-dialog').html(data.data);
            });
        });

        EditAnnouncementsBtn.on('click', function (e) {
            e.preventDefault();
            AddEditAnnouncementsModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('announcements.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditAnnouncementsModal.find('.modal-dialog').html(data.data);
            });
        });
    </script>
@endpush


