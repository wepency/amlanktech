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

    <!-- Add / Edit Categories -->
    <div class="modal fade" id="add-edit-{{$pluralModel}}" tabindex="-1" aria-labelledby="categoryModalLabel"
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
            <button type="button" data-bs-toggle="modal"
                    data-bs-target="#add-edit-{{$pluralModel}}" id="add-{{$singleModel}}-btn"
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

                    <div id="empty">
                        @include('Admin.Layouts.Partials._empty')
                    </div>

                    <div id="table" style="display: none">
                        @include('Admin.Receipt_category._table')
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection


@push('scripts')
    <script>
        const AddModelBtn = $('#add-{{$singleModel}}-btn');
        const EditModelBtn = '.edit-{{$singleModel}}-btn';
        const AddEditModelModal = $('#add-edit-{{$pluralModel}}');

        AddModelBtn.on('click', function (e) {
            e.preventDefault();
            AddEditModelModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route($pluralModel.'.create')}}').done(function (data) {
                AddEditModelModal.find('.modal-dialog').html(data.data);
            });
        });

        $('body').on('click', EditModelBtn, function (e) {
            e.preventDefault();
            AddEditModelModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route($pluralModel.'.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditModelModal.find('.modal-dialog').html(data.data);
            });
        });

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            // lengthMenu: [],
            // lengthChange: false,
            // searching: false,
            ajax: {
                url: "{{ getCurrentPageURL() }}",
                data: function (d) {
                    // d.search = $('#search').val()
                    // d.association = $('#associations-select').val()
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
                {data: 'appeal_period', name: 'appeal_period', orderable: true, searchable: false},
                {
                    data: 'status', name: 'status', orderable: true, searchable: false
                },
                {data: 'actions', name: 'actions', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc'],
            drawCallback: function () {
                // This function is called when the DataTable is loaded
                const rowCount = this.api().rows().count();

                if (rowCount > 0) {
                    $('#table').show();
                    $('#empty').hide();
                }
            }
        });
    </script>

@endpush
