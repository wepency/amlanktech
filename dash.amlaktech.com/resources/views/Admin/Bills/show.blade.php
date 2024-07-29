@extends('Admin.Layouts.Dashboard')

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <a href="{{route('dashboard.bills.index')}}" class="btn btn-danger mb-1 me-1" data-toggle="tooltip" title="العودة للسندات">
            <span class="me-1">العودة للسندات</span>
            <i class="fa fa-angle-left"></i>
        </a>

    </div>
    <!-- breadcrumb -->


    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-6">
            <div class="card text-center">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body text-center">

                    <div class="table-responsive text-center">
                        <table id="data-table" class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">الاسم</th>
                                <th scope="col">القيمة</th>
                            </tr>

                            </thead>
                            <tbody class="row_position bg-gray">

                                <tr id="{{$bill->id}}">
                                    <td>رقم السند</td>
                                    <td>{{pad_code($bill->id)}}</td>
                                
                                </tr>

                                <tr>
                                    <td>نوع السند</td>
                                    <td>{{$bill->name}}</td>
                                
                                </tr>

                                <tr>
                                    <td>قيمة السند</td>
                                    <td>{{$bill->value}}</td>
                                
                                </tr>

                                <tr>
                                    <td>تاريخ صرف السند</td>
                                    <td>{{$bill->date}}</td>
                                
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
