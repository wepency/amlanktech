@extends('Admin.Layouts.Dashboard')

@section('content')

<div class="modal fade" id="add-edit-bills" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
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
                data-bs-target="#add-edit-bills" id="add-bill-btn"
                class="btn btn-danger btn-icon mb-1 me-1">
                <i class="mdi mdi-plus"></i>
            </button>
            {{-- @endif --}}

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد السندات</span>
                <span class="badge  bg-white ms-1">{{$bills->total()}}</span>
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
                                <th scope="col">نوع السند</th>
                                <th scope="col">المبلغ</th>
                                <th scope="col">الجمعية</th>
                                <th scope="col">التاريخ</th>
                                <th scope="col">يتكرر شهريا؟</th>

                                <th scope="col">إجراءات</th>
                            </tr>

                            </thead>
                            <tbody class="row_position">

                                @foreach($bills as $bill)
                                    <tr id="{{$bill->id}}">
                                        <td>{{pad_code($bill->id)}}</td>

                                        <td>{{$bill->name}}</td>
                                        <td>{{$bill->value}}</td>

                                        <td>{{$bill?->association?->name}}</td>

                                        <td>{{$bill->date}}</td>

                                        <!-- Is repeating? -->
                                        <td>
                                            @if($bill->repeated)
                                                <span class="badge badge-success">نعم</span>
                                            @else
                                                <span class="badge badge-danger">لا</span>
                                            @endif
                                        </td>

                                        <td>
                                            <!-- Edit -->
                                            {{-- @if (can('edit bill')) --}}

                                            <button type="button" class="btn btn-primary  edit-bill-btn"
                                                data-toggle="tooltip" title="تعديل" data-bs-toggle="modal"
                                                data-bs-target="#add-edit-bills">
                                                <i class="far fa-edit"></i>
                                            </button>

                                            {{-- @endif --}}

                                            <a href="{{ route('dashboard.bills.show' , [ 'bill' => $bill->id]) }}">
                                                <button class="btn btn-secondary"  title=" عرض سند الصرف">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </a>

                                            <!-- Delete -->

                                            {{-- @if (can('delete bill')) --}}
                                            <form method="post" action="{{route('dashboard.bills.destroy', [ 'bill' => $bill->id])}}" style="display:inline-block;margin:0">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="الحذف"><i class="fas fa-trash"></i></button>
                                            </form>
                                            {{-- @endif --}}



                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
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
        const AddBillBtn = $('#add-bill-btn');
        const EditBillBtn = $('.edit-bill-btn');
        const AddEditBillModal = $('#add-edit-bills');

        AddBillBtn.on('click', function (e) {
            e.preventDefault();
            AddEditBillModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('bills.create')}}').done(function (data) {
                AddEditBillModal.find('.modal-dialog').html(data.data);

                $('body').find('#association_id').select2({
                    width: '100%',
                    placeholder: 'اختر الجمعية',
                    allowClear: true,
                    dropdownParent: $('#bill-id-form .modal-content')
                });
            });
        });

        EditBillBtn.on('click', function (e) {
            e.preventDefault();
            AddEditBillModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('bills.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditBillModal.find('.modal-dialog').html(data.data);

                $('body').find('#association_id').select2({
                    width: '100%',
                    placeholder: 'اختر الجمعية',
                    allowClear: true,
                    dropdownParent: $('#bill-id-form .modal-content')
                });
            });
        });
    </script>
@endpush


