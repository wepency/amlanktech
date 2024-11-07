@extends('Admin.Layouts.Dashboard')

@push('styles')
    <style>
        .select2-container--default .select2-selection--single {
            height: 45px;
            padding: 7px
        }

        .form-control-lg {
            font-size: 14px;
        }
    </style>
@endpush

@section('content')

    <!-- Add / Edit permits -->
    <div class="modal fade" id="add-edit-permit-categories" tabindex="-1" aria-labelledby="permitModalLabel" aria-hidden="true">
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
            <button type="button" data-bs-toggle="modal"
                    data-bs-target="#add-edit-permit-categories" id="add-permit-category-btn"
                    class="btn btn-danger mb-1 me-1">

                <i class="mdi mdi-plus"></i>

                <span>اضافة تصنيف</span>

            </button>
        </div>
    </div>

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body">

                    @include('Frontend.Partials._messages')

                    <div class="table-responsive">
                        <table id="data-table"
                               class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم التصنيف</th>
                                <th scope="col">عدد التصاريح</th>
                                <th scope="col">هل يتطلب موافقة؟</th>

                                <th scope="col">إجراءات</th>

                            </tr>

                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection


@push('scripts')
    <script>
        const AddPermitBtn = $('#add-permit-category-btn');
        const EditPermitBtn = '.edit-permit-category-btn';
        const AddEditPermitModal = $('#add-edit-permit-categories');

        AddPermitBtn.on('click', function (e) {
            e.preventDefault();
            AddEditPermitModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('permit_categories.create')}}').done(function (data) {
                AddEditPermitModal.find('.modal-dialog').html(data.data);
            });
        });

        $('body').on('click', EditPermitBtn, function (e) {
            e.preventDefault();
            AddEditPermitModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('permit_categories.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditPermitModal.find('.modal-dialog').html(data.data);
            });
        });

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            lengthMenu: [],
            lengthChange: false,
            searching: false,
            ajax: {
                url: "{{ dashboard_route('permit_categories.index') }}",
                data: function (d) {
                    d.search = $('#search').val()
                    d.association = $('#associations-select').val()
                }
            },
            language: {
                searchPlaceholder: 'بحث ...',
                scrollX: "100%",
                sSearch: '',
                info: "عرض الصفحة _PAGE_ من _PAGES_",
                lengthMenu: '_MENU_ عقار/صفحة'
            },
            columns: [
                {data: 'id', name: 'id', orderable: true, searchable: false},
                {data: 'name', name: 'owner', orderable: true, searchable: true},
                {data: 'count', name: 'count', orderable: true, searchable: true},
                {data: 'need_approval', name: 'count', orderable: true, searchable: true},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });
    </script>

@endpush
