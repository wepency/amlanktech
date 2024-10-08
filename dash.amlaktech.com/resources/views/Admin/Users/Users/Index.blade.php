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

    <!-- Add / Edit user -->
    <div class="modal fade" id="add-edit-users" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
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
                    data-bs-target="#add-edit-users" id="add-user-btn"
                    class="btn btn-danger mb-1 me-1">

                <i class="mdi mdi-plus"></i>

                <span>اضافة موظف جديد</span>

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

                    <div class="row">
                        <div class="col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for="search">كلمة البحث</label>
                                <input class="form-control form-control-lg" id="search"
                                       placeholder="ابحث عن موظف" type="text">
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

                    <div class="table-responsive">
                        <table id="data-table"
                               class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الاسم</th>
                                <th scope="col">البريد الإلكتروني</th>

                                <th scope="col">الجوال</th>
                                <th scope="col">المهنة</th>
                                <th scope="col">الراتب</th>

                                <th scope="col">الجمعية</th>

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
        const AddUserBtn = $('#add-user-btn');
        const EditUserBtn = '.edit-user-btn';
        const AddEditUserModal = $('#add-edit-users');

        AddUserBtn.on('click', function (e) {
            e.preventDefault();
            AddEditUserModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('employees.create')}}').done(function (data) {
                AddEditUserModal.find('.modal-dialog').html(data.data);
            });
        });

        $('body').on('click', EditUserBtn, function (e) {
            e.preventDefault();
            AddEditUserModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('employees.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditUserModal.find('.modal-dialog').html(data.data);
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
                url: "{{ route('dashboard.employees.index') }}",
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
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'email', name: 'email', orderable: true, searchable: true},
                {data: 'phone_number', name: 'phone_number', orderable: true, searchable: true},
                {data: 'profession', name: 'profession', orderable: true, searchable: true},
                {data: 'salary', name: 'salary', orderable: true, searchable: true},
                {data: 'association', name: 'association', orderable: true, searchable: true},
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
