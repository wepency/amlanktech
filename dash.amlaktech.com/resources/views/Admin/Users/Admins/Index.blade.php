@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit Admin -->
    <div class="modal fade" id="add-edit-admins" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-admins" id="add-admin-btn"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>المديرين</span>
                <span class="badge  bg-white ms-1">{{$admins->total()}}</span>
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

                    @if(!$admins->count())
                        <!-- Get Empty SVG if no data -->
                        @include('Admin.Layouts.Partials._empty')
                    @else
                        <div class="table-responsive">
                            <table id="data-table"
                                   class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                                <thead>

                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col"> الايميل</th>
                                    <th scope="col"> رقم الجوال</th>
                                    <th scope="col">اجراءات</th>
                                </tr>

                                </thead>
                                <tbody>

                                @foreach($admins as $admin)
                                    <tr id="{{$admin->id}}">
                                        <td>{{pad_code($admin->id)}}</td>
                                        <td>
                                            <p class="m-0">{{$admin->name}}</p>
                                            <i>{{auth('admin')->id() == $admin->id ? 'الحساب الحالي' : ''}}</i>
                                        </td>

                                        <td>{{$admin->email}}</td>
                                        <td>{{$admin->phone_number}}</td>

                                        <td>

                                            <!-- Edit -->
                                            <button type="button" class="btn btn-primary edit-admin-btn" data-toggle="tooltip"
                                                    title="تعديل" data-bs-toggle="modal"
                                                    data-bs-target="#add-edit-admins"><i class="far fa-edit"></i>
                                            </button>

                                            @if(auth('admin')->id() != $admin->id)
                                                <!-- Delete -->
                                                <form method="post"
                                                      action="{{route('dashboard.admins.destroy', $admin->id)}}"
                                                      style="display:inline-block;margin:0">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" class="btn btn-danger delete" data-toggle="tooltip"
                                                            title="الحذف"><i class="fas fa-trash"></i></button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection

@push('scripts')
    <script>
        const AddAdminBtn = $('#add-admin-btn');
        const EditAdminBtn = $('.edit-admin-btn');
        const AddEditAdminModal = $('#add-edit-admins');

        AddAdminBtn.on('click', function (e) {
            e.preventDefault();
            AddEditAdminModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('admins.create')}}').done(function (data) {
                AddEditAdminModal.find('.modal-dialog').html(data.data);
            });
        });

        EditAdminBtn.on('click', function (e) {
            e.preventDefault();
            AddEditAdminModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('admins.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditAdminModal.find('.modal-dialog').html(data.data);
            });
        });
    </script>
@endpush
