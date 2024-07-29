@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit Modal -->
    <div class="modal fade" id="add-edit-{{$singleModel}}" tabindex="-1" aria-labelledby="giftModalLabel"
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

    </div>
    <!-- breadcrumb -->

    <!-- All Budget statics -->
    @include('Admin.Budget._statics')

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body">

                    <div class="panel panel-primary tabs-style-3 mb-3">

                        <div class="tab-menu-heading">

                            <div class="tabs-menu ">

                                <ul class="nav panel-tabs justify-content-center mb-4" id="budget-types">
                                    <li><a data-type="all" class="active" data-bs-toggle="tab"><i class="fas fa-chart-line text-success"></i> الكل </a></li>
                                    <li><a data-type="subscriptions" data-bs-toggle="tab"><i class="fas fa-chart-line text-success"></i> الاشتراكات </a></li>
                                    <li><a data-type="income" data-bs-toggle="tab" class=""><i class="fas fa-file text-success"></i> سندات القبض </a></li>
                                    <li><a data-type="gifts" data-bs-toggle="tab" class=""><i class="fas fa-times text-success"></i> الهبات </a></li>
                                    <li><a data-type="payment" data-bs-toggle="tab" class=""><i class="fas fa-money-bill text-danger"></i> المصروفات </a></li>
                                </ul>

                            </div>

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="data-table"
                               class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">البند</th>
                                <th scope="col">رقم البند</th>

                                <th scope="col">تاريخ الاصدار</th>

                                <th scope="col">القيمة</th>

                                <th scope="col">الجمعية</th>

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
            // lengthMenu: [],
            // lengthChange: false,
            // searching: false,
            ajax: {
                url: "{{ dashboard_route($singleModel) }}",
                data: function (d) {
                    d.type = $('#budget-types li a.active').data('type')
                },
                "dataSrc": function (json) {
                    $('#budget-total').text(json.total)
                    $('#income-total').text(json.incomeTotal)
                    $('#payment-total').text(json.paymentTotal)

                    return json.data;
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
                {data: 'model_name', name: 'model_name', orderable: true, searchable: true},
                {data: 'model_id', name: 'model_id', orderable: true, searchable: true},
                {data: 'created_at', name: 'created_at', orderable: true, searchable: false},
                {data: 'amount', name: 'amount', orderable: true, searchable: false},
                {data: 'association', name: 'association', orderable: true, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });

        $('#budget-types li a').on('click', function () {
            table.draw()
        })
    </script>
@endpush
