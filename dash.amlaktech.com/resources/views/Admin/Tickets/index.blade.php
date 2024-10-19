@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit Gifts -->
    <div class="modal fade" id="add-edit-tickets" tabindex="-1" aria-labelledby="ticketModalLabel"
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
{{--            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-tickets" id="add-ticket-btn"--}}
{{--                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>--}}

{{--            <span class="btn btn-primary mb-1 me-1">--}}
{{--                <span>التذاكر</span>--}}
{{--                <span id="tickets-count" class="badge bg-white ms-1"></span>--}}
{{--            </span>--}}
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

                    <div class="table-responsive">
                        <table id="data-table"
                               class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">

                            <thead>

                            <tr>

                                <th scope="col">الكود</th>
                                <th scope="col">الطلب</th>

                                <th scope="col">عضو الجمعية</th>

                                <th scope="col">التصنيف</th>

                                @if(is_admin())
                                    <th scope="col">الجمعية</th>
                                @endif

                                <th scope="col">أخر رد</th>

                                <th>تاريخ انشاء التذكرة</th>

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
        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            lengthMenu: [],
            lengthChange: false,
            searching: false,
            ajax: {
                url: "{{ route('dashboard.tickets.index') }}",
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
                {data: 'code', name: 'code', orderable: true, searchable: true},
                {data: 'title', name: 'title', orderable: true, searchable: true},
                {data: 'member', name: 'member', orderable: true, searchable: true},

                {data: 'category', name: 'category', orderable: true, searchable: false},

                @if(is_admin())
                    {data: 'association', name: 'association', orderable: true, searchable: true},
                @endif

                {data: 'last_message', name: 'last_message', orderable: true, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: true, searchable: false},
                {data: 'status', name: 'association', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });
    </script>
@endpush
