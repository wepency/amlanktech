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


            <a href="{{route('dashboard.admins.index')}}" class="btn btn-danger mb-1 me-1" data-toggle="tooltip" title="العودة للجمعيات">
                <span class="me-1">العودة للمديرين</span>
                <i class="fa fa-angle-left"></i>
            </a>
        </div>

        
    </div>
    <!-- breadcrumb -->


    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">عنوان المدير /</h3>
                    <h6>{{$admin->name}} </h6>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="data-table" class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                            <thead>

                                <tr>
                                    <th scope="col">#</th>
                            
                                    <th scope="col">  الدوله</th>
                                    <th scope="col">  المقاطعه</th>
                                    <th scope="col">  المنطقه</th>
                                    <th scope="col">  الشارع</th>
                                    <th scope="col">  المبنى</th>
                                    <th scope="col">ملاحظات </th>
                                </tr>

                            </thead>
                            <tbody class="row_position">

                                <tr id="{{$address->id}}">
                                    <td>{{pad_code($address->id)}}</td>
                                    
                                    <td>{{($address->country) }}</td>
                                    <td>{{$address->province}}</td>
                                    <td>{{$address->region}}</td>
                                    <td>{{$address->street}}</td>
                                    <td>{{$address->building}}</td>
                                    <td>{{$address->notes}}</td>
                                    
                                    </td>
                                </tr>

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
