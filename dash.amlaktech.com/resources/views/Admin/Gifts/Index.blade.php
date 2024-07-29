@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit Gifts -->
    <div class="modal fade" id="add-edit-gifts" tabindex="-1" aria-labelledby="giftModalLabel"
         aria-hidden="true">
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
            {{-- @if (can('add gift')) --}}
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-gifts" id="add-gift-btn"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>
            {{-- @endif --}}

            <span class="btn btn-primary mb-1 me-1">
                <span>الهبات</span>
                <span id="gifts-count" class="badge bg-white ms-1"></span>
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

                    @if(!$gifts->count())
                        <!-- Get Empty SVG if no data -->
                        @include('Admin.Layouts.Partials._empty')
                    @else
                        <!-- Get all filters needed for index -->
{{--                        @include('Admin.Gifts._index_filter')--}}

                        <!-- Get datatable html table -->
                        @include('Admin.Gifts._table')
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@push('scripts')
    <script>
        const AddGiftBtn = $('#add-gift-btn');
        const EditGiftBtn = $('.edit-gift-btn');
        const AddEditGiftModal = $('#add-edit-gifts');

        $('.select2').select2()

        AddGiftBtn.on('click', function (e) {
            e.preventDefault();
            AddEditGiftModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('gifts.create')}}').done(function (data) {
                AddEditGiftModal.find('.modal-dialog').html(data.data);
                newModalUpdate();
            });
        });

        EditGiftBtn.on('click', function (e) {
            e.preventDefault();
            AddEditGiftModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('gifts.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditGiftModal.find('.modal-dialog').html(data.data);
                newModalUpdate();
            });
        });

        function newModalUpdate() {
            $('#association-member-id').select2({
                dropdownParent: $('.modal-content')
            })
        }

    </script>
@endpush
