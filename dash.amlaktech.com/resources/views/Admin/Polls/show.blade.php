@extends('Admin.Layouts.Dashboard')

@section('content')

<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
            <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{ $page_title }}"{{ $poll->name }}"</span>
        </div>
    </div>

    <div class="d-flex my-xl-auto right-content">

        <a href="{{route('dashboard.polls.index')}}" class="btn btn-danger mb-1 me-1" data-toggle="tooltip" title="العودة للشركات">
            <span class="me-1">العودة للتصويتات</span>
            <i class="fa fa-angle-left"></i>
        </a>

    </div>
</div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $page_title }}" {{ $poll->name }} " </h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="data-table" class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">الاسم</th>
                            </tr>

                            </thead>
                            <tbody class="row_position">

                                    @foreach ($poll->options as $key=>$option)
                                        <tr>
                                            <td>     {{ $key+1 }}</td> 
                                            <td>{{ $option->option }}</td>
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
