@extends('Admin.Layouts.Dashboard')

@section('content')



    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-admin" id="add-admin" class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الجمعيات</span>
                <span class="badge  bg-white ms-1">{{$invoicesCount}}</span>
            </span>
        </div>
    </div>
    <!-- breadcrumb -->

    {{--    @include('Partners.Units.Statics')--}}

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="data-table" class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الاسم</th>
                                <th scope="col"> العنوان</th>
                                <th scope="col">رقم الجوال</th>
                                <th scope="col">أخر تسجيل دخول</th>
                                <th scope="col">اجراءات</th>
                            </tr>

                            </thead>
                            <tbody class="row_position">

                                @foreach($associations as $association)
                                    <tr id="{{$association->id}}">
                                        <td>{{pad_code($association->id)}}</td>
                                        <td>{{$association->title}}</td>
                                        <td>{!! get_status_badge($association->is_active) !!}</td>

                                        <td>{{$association->lessons_count}}</td>

                                        <td>
                                            <!-- Edit -->
                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" title="تعديل" data-bs-toggle="modal" data-bs-target="#edit-user-{{$association->id}}"><i class="far fa-edit"></i></button>

                                                <!-- Delete -->
                                                <form method="post" action="{{route('dashboard.associations.destroy', [ 'month' => $association->id])}}" style="display:inline-block;margin:0">
                                                    @csrf
                                                    @method('delete')

                                                    <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="الحذف"><i class="fas fa-trash"></i></button>
                                                </form>

                

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

@section('scripts')
   
@endsection
