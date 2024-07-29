@extends('Admin.Layouts.Dashboard')

@push('styles')
    <style>
        #toggle-member-form .hide-member{
            display: none;
        }

        #toggle-member-form.member-on .hide-member{
            display: block;
        }

        #toggle-member-form.member-on .show-member{
            display: none;
        }
    </style>
@endpush

@section('content')

    <!-- Add / Edit Admin -->
    <div class="modal fade" id="add-edit-unit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-unit" id="add-unit-btn" class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>  عدد الوحدات </span>
                <span class="badge  bg-white ms-1">{{$unitsCount}}</span>
            </span>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">

        @include('Admin.Units.table')

    </div>
    <!-- End Row -->
@endsection

@push('scripts')

    <script>
        const AddUnitBtn = $('#add-unit-btn');
        const EditUnitBtn = $('.edit-unit-btn');
        const AddEditUnitModal = $('#add-edit-unit');

        AddUnitBtn.on('click', function (e) {
            e.preventDefault();
            AddEditUnitModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('units.create')}}').done(function (data) {
                AddEditUnitModal.find('.modal-dialog').html(data.data);
            });
        });

        EditUnitBtn.on('click', function (e) {
            e.preventDefault();

            AddEditUnitModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('units.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditUnitModal.find('.modal-dialog').html(data.data);
            });
        });
    </script>
@endpush
