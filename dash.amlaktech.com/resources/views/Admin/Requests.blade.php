@extends('Admin.Layouts.Dashboard')

@push('styles')
    <link href="{{asset('css/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>

    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-hijri-datetimepicker.min.js')}}"></script>
@endpush

@section('content')

    <!-- Add / Edit Member -->
    <div class="modal fade" id="accept-unit" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
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

            <span class="btn btn-primary mb-1 me-1">
                <span>{{$page_title}}</span>
                <span id="requests-total" class="badge bg-white ms-1"></span>
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

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="association">أعضاء الجمعية</label>

                            <select class="select2 form-control" name="association" id="association">
                                <option value="">الكل</option>

                                @foreach($associations as $association)
                                    <option value="{{$association->id}}">{{$association->name}}</option>
                                @endforeach
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
                                <th scope="col">رقم الجوال</th>

                                @if(is_admin())
                                    <th scope="col">الجمعيات</th>
                                @endif

                                <th scope="col">نوع الملكية</th>
                                <th scope="col">عدد الشركاء</th>
                                <th scope="col">نسبة الملكية</th>
                                <th scope="col">قيمة الاشتراك</th>
                                <th scope="col">العنوان</th>
                                <th scope="col">رقم عداد المياه</th>
                                <th scope="col">رقم عداد الكهرباء</th>

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
        const AcceptUnitBtn = '.accept-unit-btn';
        const AcceptUnitModal = $('#accept-unit');

        $('.select2').select2();

        const pickerOpt = {
            locale:'ar-SA',
            useCurrent: true,
            format:'DD-MM-YYYY',
            hijriFormat:'DD-MM-YYYY',
            hijriText: "عرض التاريخ الهجري",
            gregorianText: "عرض التاريخ الميلادي"
        }

        $('body').on('click', AcceptUnitBtn, function (e) {
            e.preventDefault();
            AcceptUnitModal.find('.modal-dialog').html(getPreloader());

            let url = '{{dashboard_route('units.accept.modal', ':id')}}'
            url = url.replace(':id', $(this).parents('tr').attr('id'));

            $.get(url).done(function (data) {
                AcceptUnitModal.find('.modal-dialog').html(data.data);
                $(".valid_to").hijriDatePicker(pickerOpt);
            });
        });


        // $('body').on('click', '.accept', function (e) {
        //     e.preventDefault();
        //
        //     const form = $(this).parents('form');
        //
        //     Swal.fire({
        //         title: "هل انت متأكد؟",
        //         text: "هل انت متأكد من قبول العضو؟",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "قبول",
        //         cancelButtonText: "الغاء",
        //         dangerMode: true,
        //     }).then(function (result) {
        //         if (result.isConfirmed) {
        //             form.submit();
        //         }
        //     })
        //
        // });

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('dashboard.units.requests') }}",
                "dataSrc": function (json) {
                    $('#requests-total').text(json.total)

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
                {data: 'phone_number', name: 'phone_number', orderable: true, searchable: true},

                    @if(is_admin())
                {
                    data: 'association', name: 'association', orderable: true, searchable: true
                },
                    @endif

                {data: 'ownership_type', name: 'ownership_type', orderable: true, searchable: false},
                {data: 'partners_amount', name: 'partners_amount', orderable: true, searchable: false},
                {data: 'ownership_ratio', name: 'ownership_ratio', orderable: true, searchable: false},
                {data: 'fee_type_total', name: 'fee_type_total', orderable: true, searchable: false},

                {data: 'address', name: 'address', orderable: true, searchable: false},
                {data: 'water_meter_serial', name: 'water_meter_serial', orderable: true, searchable: false},
                {data: 'electricity_meter_serial', name: 'electricity_meter_serial', orderable: true, searchable: false},

                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });

        $('#association').on('change', function (){
            table.draw()
        })

    </script>
@endpush
