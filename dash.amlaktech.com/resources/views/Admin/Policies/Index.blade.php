@extends('Admin.Layouts.Dashboard')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

@section('content')

    <!-- Add/Edit Policies Modal -->
    <div class="modal fade" id="add-edit-policies" tabindex="-1"
         aria-labelledby="policyModalLabel" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    <a href="{{ dashboard_route('home') }}">
                        @lang('labels.dashboard')
                    </a>
                </h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{ $page_title }}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">

            <!-- Add Policy Button -->
            <button type="button" data-bs-toggle="modal"
                    data-bs-target="#add-edit-policies" id="add-policy-btn"
                    class="btn btn-danger btn-icon mb-1 me-1">
                <i class="mdi mdi-plus"></i>
            </button>

            <!-- Number of Policies Badge -->
            <span class="btn btn-primary mb-1 me-1">
                <span>@lang('labels.number_of_policies')</span>
                <span class="badge  bg-white ms-1">{{ $policies->total() }}</span>
            </span>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Main Content -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body">

                    @if(!$policies->count())
                        @include('Admin.Layouts.Partials._empty')
                    @else
                        @include('Admin.Policies._table')
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        const AddPolicyBtn = $('#add-policy-btn');
        const EditPolicyBtn = $('.edit-policy-btn');
        const AddEditPolicyModal = $('#add-edit-policies');

        // Handle Add Policy Button Click
        AddPolicyBtn.on('click', function (e) {
            e.preventDefault();
            AddEditPolicyModal.find('.modal-dialog').html(getPreloader());

            $.get('{{ dashboard_route('policies.create') }}').done(function (data) {
                AddEditPolicyModal.find('.modal-dialog').html(data.data);
            });
        });

        // Handle Edit Policy Button Click
        EditPolicyBtn.on('click', function (e) {
            e.preventDefault();
            AddEditPolicyModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{ dashboard_route('policies.edit', ':id') }}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditPolicyModal.find('.modal-dialog').html(data.data);
            });
        });
    </script>
@endpush
