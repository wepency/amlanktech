@extends('Admin.Layouts.Dashboard')

@section('content')

    <div class="modal fade" id="add-edit-receipts" tabindex="-1" aria-labelledby="receiptModalLabel"
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

            {{-- @if (can('add bill')) --}}
            <button type="button" data-bs-toggle="modal"
                    data-bs-target="#add-edit-receipts" id="add-receipt-btn"
                    class="btn btn-danger btn-icon mb-1 me-1">
                <i class="mdi mdi-plus"></i>
            </button>
            {{-- @endif --}}

            <span class="btn btn-primary mb-1 me-1">
                <span>{{$page_title}}</span>
                <span class="badge  bg-white ms-1">{{$receipts->count()}}</span>
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
                    @include('Admin.payment_receipts._table')
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@push('scripts')
    <script>


        const AddReceiptsBtn = $('#add-receipt-btn');
        const EditReceiptsBtn = '.edit-receipt-btn';
        const AddEditReceiptsModal = $('#add-edit-receipts');

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
                url: "{{ dashboard_route('payment-receipts.index') }}",
                data: function (d) {
                    d.type = "{{request()->get('type')}}";
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
                {data: 'title', name: 'title', orderable: true, searchable: true},
                    @if(is_admin())
                {data: 'association', name: 'association', orderable: true, searchable: false},
                    @endif

                {data: 'date', name: 'date', orderable: true, searchable: true},
                {data: 'amount', name: 'amount', orderable: true, searchable: false},
                {data: 'payment_type', name: 'payment_type', orderable: true, searchable: false},
                {data: 'status', name: 'status', orderable: true, searchable: false},
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });

        $('body').on('click', '.accept-row', function (e) {
            e.preventDefault();

            const form = $(this).parents('form');

            Swal.fire({
                title: "هل توافق على قبول الطلب؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "قبول",
                cancelButtonText: "الغاء",
                dangerMode: true,
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });

    </script>
@endpush
