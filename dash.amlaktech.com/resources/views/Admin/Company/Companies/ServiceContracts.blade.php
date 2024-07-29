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

            <a href="{{route('dashboard.companies.index')}}" class="btn btn-danger mb-1 me-1" data-toggle="tooltip" title="العودة للشركات">
                <span class="me-1">العودة للشركات</span>
                <i class="fa fa-angle-left"></i>
            </a>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد العقود الخدمية</span>
                <span class="badge  bg-white ms-1">{{$services->count()}}</span>
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
                                <th scope="col">نوع الخدمة</th>
                                <th scope="col">الشركة</th>
                                <th scope="col">القيمة</th>
                                <th scope="col">العقد</th>
                                <th scope="col">اجراءات</th>
                            </tr>

                            </thead>
                            <tbody class="row_position">

                                @foreach($services as $service)
                                    <tr id="{{$service->id}}">
                                        <td>{{pad_code($service->id)}}</td>
                                        <td>{{$service->service_type}}</td>
                                        <td>{{$service->company->name}}</td>
                                        <td>{{$service->amount}}</td>
                                    
                                        <td>

                                            <a href="{{ route('dashboard.services.download_contract' , [ 'service' => $service->id]) }}"> 
                                                <button class="btn btn-secondary"  title="  تنزيل العقد ">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </a>

                                        </td>

                                        <td>
                                            <!-- Edit -->
                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" title="تعديل" data-bs-toggle="modal" data-bs-target="#edit-service-{{$service->id}}"><i class="far fa-edit"></i></button>

                                            <!-- Delete -->
                                            <form method="post" action="{{route('dashboard.services.destroy', [ 'service' => $service->id])}}" style="display:inline-block;margin:0">
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
