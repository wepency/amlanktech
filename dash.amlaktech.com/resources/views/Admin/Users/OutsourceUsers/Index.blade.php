@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit user -->
    <div class="modal fade" id="add-edit-users" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
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
                    data-bs-target="#add-edit-users" id="add-user-btn"
                    class="btn btn-danger btn-icon mb-1 me-1">
                <i class="mdi mdi-plus"></i>
            </button>

            <span class="btn btn-primary mb-1 me-1">
                <span>الموظفون خارج النظام</span>
                <span class="badge  bg-white ms-1">{{$users->total()}}</span>
            </span>
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

                    @if(!$users->count())
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
                                    <th scope="col"> البريد الإلكتروني</th>
                                    <th scope="col"> الجوال</th>
                                    <th scope="col">المهنة</th>
                                    <th scope="col">الراتب</th>
                                    <th scope="col">إجراءات</th>
                                </tr>

                                </thead>
                                <tbody class="row_position">

                                @foreach($users as $user)
                                    <tr id="{{$user->id}}">
                                        <td>{{pad_code($user->id)}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone_number}}</td>
                                        <td>{{$user->profession}}</td>
                                        <td>{{$user->salary}}</td>

                                        <td>

                                            <!-- Edit -->
                                            <button type="button" class="btn btn-primary  edit-user-btn"
                                                    data-toggle="tooltip" title="تعديل" data-bs-toggle="modal"
                                                    data-bs-target="#add-edit-users">
                                                <i class="far fa-edit"></i>
                                            </button>

                                            <!-- Delete -->
                                            <form method="post"
                                                  action="{{route('dashboard.outsource_employees.destroy', $user->id)}}"
                                                  style="display:inline-block;margin:0">
                                                @csrf
                                                @method('delete')

                                                <button type="submit" class="btn btn-danger delete"
                                                        data-toggle="tooltip" title="الحذف"><i class="fas fa-trash"></i>
                                                </button>
                                            </form>


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
        const AddUserBtn = $('#add-user-btn');
        const EditUserBtn = $('.edit-user-btn');
        const AddEditUserModal = $('#add-edit-users');

        AddUserBtn.on('click', function (e) {
            e.preventDefault();
            AddEditUserModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('outsource_employees.create')}}').done(function (data) {
                AddEditUserModal.find('.modal-dialog').html(data.data);
            });
        });

        EditUserBtn.on('click', function (e) {
            e.preventDefault();
            AddEditUserModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            let url = '{{dashboard_route('outsource_employees.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditUserModal.find('.modal-dialog').html(data.data);
            });
        });
    </script>
@endpush
