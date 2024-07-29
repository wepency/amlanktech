@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit permissions group -->
    <div class="modal fade" id="add-edit-{{$singleModel}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"></div>
    </div>

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-{{$singleModel}}" id="add-{{$singleModel}}-btn"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الادوار</span>
                <span class="badge  bg-white ms-1">{{$rolesCount}}</span>
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
                    @if($rows->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>مجموعة الصلاحية</th>
                                    <th>المستخدمين</th>
                                    <th>الإجراءات</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($rows as $row)
                                    <tr id="{{$row->id}}">
                                        <td>{{$row->main_name}}</td>
                                        <td>
                                                <?php
                                                $users = App\Models\Admin::role($row->name)->get()
                                                ?>

                                            @foreach($users as $user)
                                                <div class="text-primary m-0">{{$user->name}}
                                                    <form style="display: inline-block; margin: 0" method="POST" action="{{dashboard_route('roles.users.remove', [$row->id, $user->id])}}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="btn btn-link delete" type="submit">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </td>

                                        <td>
                                            <div class="table-buttons">
                                                {{--                                                    @if(can('edit permissions'))--}}
                                                <button class="btn btn-primary btn-icon edit-{{$singleModel}}-btn"
                                                        data-bs-toggle="modal" data-bs-target="#add-edit-{{$singleModel}}"><i
                                                        class="fa fa-edit"></i></button>
                                                {{--                                                    @endif--}}

{{--                                                @if(can('delete permissions'))--}}
                                                    @if($row->name != 'mdyr-aaam' && $row->name != 'mdyr-ktaaa')
                                                        <form id="permission-{{$row->id}}"
                                                              action="{{dashboard_route('roles.destroy', $row->id)}}"
                                                              method="post" style="margin: 0;display: inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-icon delete"
                                                                    type="submit"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    @endif
{{--                                                @endif--}}

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{$rows->withQueryString()}}

                    @else
                        @include('Admin.Layouts.Partials._empty')
                    @endif
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
            const AddEditModelModal = $('#add-edit-{{$singleModel}}');

            AddModelBtn.on('click', function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                $.get('{{dashboard_route('roles.create')}}').done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });

            $('body').on('click', EditModelBtn, function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('roles.edit', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });
        });
    </script>
@endpush
