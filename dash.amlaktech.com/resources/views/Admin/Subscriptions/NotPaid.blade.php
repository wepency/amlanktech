@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit Subscription -->
  
    <div class="modal fade" id="add-subscription" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            @include('Admin.Subscriptions.create')

        </div>
    </div>

  
    @foreach($subscriptions as $subscription)
        <div class="modal fade" id="edit-subscription-{{$subscription->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                @include('Admin.Subscriptions.edit')

            </div>
        </div>
    @endforeach

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">

            <button type="button" data-bs-toggle="modal" data-bs-target="#add-subscription" id="add-admin" class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الاشتراكات</span>
                <span class="badge  bg-white ms-1">{{$subscriptions->count()}}</span>
            </span>
        </div>
    </div>
    <!-- breadcrumb -->

    {{--    @include('Partners.Units.Statics')--}}

    <!-- Row -->
    <div class="row row-sm">

        @include('Admin.Subscriptions.table')

    </div>
    <!-- End Row -->
@endsection

@section('scripts')
   
@endsection
