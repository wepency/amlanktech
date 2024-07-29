@extends('Admin.Layouts.Dashboard')

@push('styles')
    <style>
        #toggle-manager-form .hide-manager{
            display: none;
        }

        #toggle-manager-form.manager-on .hide-manager{
            display: block;
        }

        #toggle-manager-form.manager-on .show-manager{
            display: none;
        }
    </style>
@endpush

@section('content')

    <!-- Add / Edit Association -->
    <div class="modal fade" id="add-edit-associations" tabindex="-1" aria-labelledby="associationModalLabel"
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-associations"
                    id="add-association-btn"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الجمعيات</span>
                <span class="badge  bg-white ms-1">{{$associations->total()}}</span>
            </span>
        </div>
    </div>

    <!-- Row -->
    <div class="row row-sm">
        @include('Admin.Associations.table')
    </div>
    <!-- End Row -->
@endsection

@push('scripts')
    <script>
        const AddAssociationBtn = $('#add-association-btn');
        const EditAssociationBtn = $('.edit-association-btn');
        const AddEditAssociationModal = $('#add-edit-associations');

        AddAssociationBtn.on('click', function (e) {
            e.preventDefault();
            AddEditAssociationModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('associations.create')}}').done(function (data) {
                AddEditAssociationModal.find('.modal-dialog').html(data.data);
                newModalUpdate();
            });
        });

        EditAssociationBtn.on('click', function (e) {
            e.preventDefault();
            AddEditAssociationModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('associations.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditAssociationModal.find('.modal-dialog').html(data.data);
                newModalUpdate();
            });
        });

        function newModalUpdate() {
            changeProvince()
            changeFees();
        }

        function changeProvince() {
            let province_url = '{{url('/api/dashboard/provinces')}}';

            $('body').find('#province').select2({
                placeholder: '',
                allowClear: true,
                ajax: {
                    url: province_url,
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                }
            });
        }

        function changeCity(val) {
            let city_url = '{{url('/api/dashboard/cities/:id')}}';

            city_url = city_url.replace(':id', val)

            $('#city').select2({
                placeholder: '',
                allowClear: true,
                ajax: {
                    url: city_url,
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                }
            });
        }

        $('body').on('change', '#province', function () {
            changeCity($(this).val())
        })

        $('body').on('change', '#fees_type', function (){

            var selectedOption = $(this).find(':selected');
            var label = selectedOption.data('label');

            $('#fee_amount_label').text(label);

        })

        function changeFees() {
            $('body').find('#fees_type').select2({
                allowClear: true
            });
        }
    </script>
@endpush
