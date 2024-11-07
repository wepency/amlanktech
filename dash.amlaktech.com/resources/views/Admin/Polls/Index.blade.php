@extends('Admin.Layouts.Dashboard')

@section('content')

    <div class="modal fade" id="add-edit-polls" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-poll" id="add-poll"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد التصويتات</span>
                <span class="badge  bg-white ms-1">{{$polls->count()}}</span>
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

                    <div class="table-responsive">
                    <table id="data-table" class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">

                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">التصويت</th>
                                <th scope="col">تم انشاؤه بواسطة</th>

                                @if(is_admin())
                                    <th scope="col">الجمعية</th>
                                @endif

                                <th scope="col">الخيارات</th>
                                <th scope="col">عدد الأصوات</th>
                                <th scope="col">تاريخ الانشاء</th>
                                <th scope="col">اجراءات</th>
                            </tr>

                            </thead>
                            <tbody></tbody>

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

        const AddReceiptsBtn = $('#add-poll-btn');
        const EditReceiptsBtn = '.edit-poll-btn';
        const AddEditReceiptsModal = $('#add-edit-polls');

        AddReceiptsBtn.on('click', function (e) {
            e.preventDefault();
            AddEditReceiptsModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('payment-receipts.create')}}').done(function (data) {
                AddEditReceiptsModal.find('.modal-dialog').html(data.data);
            });
        });

        $('body').on('click', EditReceiptsBtn, function (e) {
            e.preventDefault();
            AddEditReceiptsModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('payment-receipts.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditReceiptsModal.find('.modal-dialog').html(data.data);
            });
        });

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ dashboard_route('polls.index') }}",
                data: function (d) {
                    {{--d.type = "{{request()->get('type')}}";--}}
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
                {data: 'created_by', name: 'created_by', orderable: true, searchable: true},

                    @if(is_admin())
                {
                    data: 'association', name: 'association', orderable: true, searchable: false
                },
                    @endif

                {data: 'items', name: 'items', orderable: true, searchable: false},
                {data: 'votes', name: 'votes', orderable: true, searchable: false},
                {data: 'created_at', name: 'created_at', orderable: true, searchable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });

    </script>

@endpush
