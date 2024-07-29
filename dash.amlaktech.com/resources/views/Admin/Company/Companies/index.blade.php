@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit companies group -->
    <div class="modal fade" id="add-edit-{{$pluralModel}}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Agreements group -->
    <div class="modal fade" id="agreements" tabindex="-1" aria-labelledby="agreementModalLabel"
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-{{$pluralModel}}"
                    id="add-{{$singleModel}}-btn"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- All Company statics -->
    @include('Admin.Company.Companies._statics')

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
                               class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم الشركة</th>
                                @if(is_admin())
                                    <th scope="col">الجمعية</th>
                                @endif
                                <th scope="col">مضافة للميزانية؟</th>
                                <th scope="col">مبلغ التعاقد</th>
                                <th scope="col">العقد</th>
                                <th scope="col">موافقات الأعضاء</th>

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
        $(document).ready(function () {

            const AddModelBtn = $('#add-{{$singleModel}}-btn');
            const EditModelBtn = '.edit-{{$singleModel}}-btn';
            const AddEditModelModal = $('#add-edit-{{$pluralModel}}');
            const ShowAgreementsModal = $('#agreements');

            AddModelBtn.on('click', function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                $.get('{{dashboard_route('companies.create')}}').done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });

            $('body').on('click', EditModelBtn, function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('companies.edit', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });

            // Show agreements
            $('body').on('click', '.show-agreements', function (e) {
                e.preventDefault();
                ShowAgreementsModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('companies.agreements', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    ShowAgreementsModal.find('.modal-dialog').html(data.data);
                });
            });

            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ dashboard_route('companies.index') }}",
                    "dataSrc": function (json) {
                        $('#companies-total').text(json.total)
                        $('#added-to-budget-total').text(json.addedToBudgetTotal)
                        $('#admin-agreement-total').text(json.adminAgreementTotal)
                        $('#amount-total').text(json.amountTotal)

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
                    {data: 'name', name: 'name', orderable: true, searchable: true},
                        @if(is_admin())
                    {
                        data: 'association', name: 'association', orderable: true, searchable: false
                    },
                        @endif

                    {
                        data: 'added_to_budget', name: 'added_to_budget', orderable: true, searchable: false
                    },
                    {data: 'amount', name: 'amount', orderable: true, searchable: false},
                    {data: 'file_path', name: 'file_path', orderable: false, searchable: false},
                    {data: 'admin_agreements', name: 'admin_agreements', orderable: true, searchable: false},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                responsive: true,
                order: [0, 'desc']
            });
        });
    </script>
@endpush
