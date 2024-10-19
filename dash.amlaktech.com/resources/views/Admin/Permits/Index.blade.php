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

        /* Hide arrows for Chrome, Safari, Edge, and Opera */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide arrows for Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('content')

    <!-- Add / Edit permits -->
    <div class="modal fade" id="add-edit-permits" tabindex="-1" aria-labelledby="permitModalLabel" aria-hidden="true">
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
                    data-bs-target="#add-edit-permits" id="add-permit-btn"
                    class="btn btn-danger mb-1 me-1">

                <i class="mdi mdi-plus"></i>

                <span>اضافة تصريح</span>

            </button>
        </div>
    </div>

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">بحث وتصفية</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for="search">كلمة البحث</label>
                                <input class="form-control form-control-lg" id="search"
                                       placeholder="ابحث عن تصريح" type="text">
                            </div>
                        </div>

                        @if(is_admin())
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="payment-status">الجمعية</label>
                                    @include('Admin.Layouts.Partials._associations-select', [
                                        'id' => 'associations-select'
                                    ])
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-3 col-xs-12">
                            <label for="customSelect">عدد النتائج في الصفحة:</label>

                            <select class="form-control form-control-lg" id="customSelect">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
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
                                <th scope="col">اسم المالك</th>
                                <th scope="col">الجمعية</th>

                                <th scope="col">عدد ايام التصريح</th>
                                <th scope="col">تاريخ الدخول</th>
                                <th scope="col">مرات الدخول</th>
                                <th scope="col">الزوار</th>

                                <th scope="col">الحالة</th>
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
        const AddPermitBtn = $('#add-permit-btn');
        const EditPermitBtn = '.edit-permit-btn';
        const AddEditPermitModal = $('#add-edit-permits');

        AddPermitBtn.on('click', function (e) {
            e.preventDefault();
            AddEditPermitModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('permits.create')}}').done(function (data) {
                AddEditPermitModal.find('.modal-dialog').html(data.data);
            });
        });

        $('body').on('click', EditPermitBtn, function (e) {
            e.preventDefault();
            AddEditPermitModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('permits.edit', ':id')}}';
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
                url: "{{ route('dashboard.permits.index') }}",
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
                {data: 'owner', name: 'owner', orderable: true, searchable: true},
                {data: 'association', name: 'association', orderable: true, searchable: true},
                {data: 'login_attempts', name: 'login_attempts', orderable: true, searchable: false},
                {data: 'start_date', name: 'start_date', orderable: true, searchable: false},
                {data: 'permit_days', name: 'permit_days', orderable: true, searchable: false},
                {data: 'visitors', name: 'visitors', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: true, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });

        @if(is_admin())
        $('.associations-select').val('');

        $('.associations-select').select2({
            placeholder: 'تصفية حسب الجمعية',
            allowClear: true,
        })

        $('.associations-select').on('change', function () {
            table.draw()
        })
        @endif


        $('#search').on('keyup', function () {
            table.draw()
        })

        $('#customSelect').on('change', function () {
            var selectedValue = $(this).val();
            table.page.len(selectedValue).draw(); // Set the page length and redraw the table
        });
    </script>

@endpush
