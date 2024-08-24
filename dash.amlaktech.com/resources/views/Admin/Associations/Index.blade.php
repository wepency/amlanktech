@extends('Admin.Layouts.Dashboard')

@push('styles')
    <style>
        #toggle-manager-form .hide-manager {
            display: none;
        }

        #toggle-manager-form.manager-on .hide-manager {
            display: block;
        }

        #toggle-manager-form.manager-on .show-manager {
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

    <!-- Add Admin -->
    <div class="modal fade" id="add-admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="" id="bill-id-form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @csrf

                        <div class="form-group">
                            <label for="name">الاسم <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add-name" name="name"
                                   value="{{old('name')}}" required/>
                        </div>

                    </div>
                </div>
            </form>
        </div>
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

        $('body').on('change', '#fees_type', function () {

            var selectedOption = $(this).find(':selected');
            var label = selectedOption.data('label');

            $('#fee_amount_label').text(label);

        })

        function changeFees() {
            $('body').find('#fees_type').select2({
                allowClear: true
            });
        }

        $('body').on('select2:select', '#admin_id', function (e) {

            const data = e.params.data;
            if (data.id === 'add-new') {
                // Open Add User modal if 'Add New User' is selected
                $('#add-admin').css('z-index', 999999999); // Increase z-index
                $('.modal-backdrop').css('z-index', 1050); // Adjust backdrop z-index
                $('#add-admin').modal('show');

                // Prevent body scroll
                $('body').addClass('modal-open');

                $.get('{{url('/admin/api/admins/create')}}').done(function (data) {
                    $('#add-admin').find('.modal-dialog').html(data.data);
                });
            }
        });

        $('body').on('submit', '#ajax-form', function (e) {
            e.preventDefault();

            const formDate = $(this).serialize();
            const form = $(this);

            $.ajax({
                url: '{{url('/admin/api/admins/store')}}',
                data: formDate,
                type: 'POST',
                success: function (user) {
                    var newOption = new Option(user.data.name+' - '+user.data.phone_number, user.data.id, false, true);
                    $('#admin_id').append(newOption);

                    // Close the Add User modal and reopen the User Select modal
                    $('#add-admin').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Validation error
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        $.each(errors, function (key, value) {
                            errorMessage += '<li>' + value[0] + '</li>';
                        });

                        form.find('#error-list').html(errorMessage);
                        form.find('#error-message').removeClass('d-none'); // Show the alert
                    }
                }
            })
        })

        // When the new modal is hidden, adjust z-index and manage scrolling
        $('#add-admin').on('hidden.bs.modal', function () {
            // Reset z-index for the backdrop
            $('.modal-backdrop').last().css('z-index', '');

            // Check if there's any other modal open
            if ($('.modal.show').length) {
                $('body').addClass('modal-open');
            } else {
                $('body').removeClass('modal-open');
            }
        });


        $('body').on('submit', '#create-association', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const form = $(this);

            const url = form.attr('action')

            $.ajax({
                url: url,
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting contentType
                type: 'POST',
                success: function (data) {
                    AddEditAssociationModal.modal('hide');
                    toastr.success("تم اضافة الجمعية بنجاح.");
                },
                error: function(xhr)  {
                    if (xhr.status === 422) { // Validation error
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        $.each(errors, function (key, value) {
                            errorMessage += '<li>' + value[0] + '</li>';
                        });

                        form.find('#error-list').html(errorMessage);
                        form.find('#error-message').removeClass('d-none'); // Show the alert
                    }
                }
            })
        });
    </script>
@endpush
