@extends('Admin.Layouts.Dashboard')

@push('styles')
    <!-- Include Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

    <style>
        .card-footer .btn, .card-footer form {
            flex: 1;
        }
    </style>
@endpush

@section('content')

    <!-- Add / Edit Tasks -->
    <div class="modal fade" id="add-edit-{{$pluralModel}}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-{{$pluralModel}}"
                    id="add-{{$singleModel}}-btn"
                    class="btn btn-danger mb-1 me-1"><i class="mdi mdi-plus"></i> اضافة مهمة جديدة
            </button>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- All Posts statics -->
    @include('Admin.Tasks._statics')

    @if(!$tasks->count())

        <div class="card">
            <div class="card-body">
                @include('Admin.Layouts.Partials._empty')
            </div>
        </div>

    @else

        <div class="row">

            @foreach($tasks as $task)
                @php
                    $progress = getTaskProgress($task)
                @endphp

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="card" id="{{$task->id}}">
                        <div class="card-body iconfont text-start">

                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-3">{{$task->title}}</h4>
                            </div>

                            <div class="d-flex mb-0">
                                <div class="">
                                    <h4 class="mb-1 fw-bold"><span style="display: inline-block;direction: ltr;">{{optional($task?->target_date)->format('d M, Y')}}</span> <span style="direction: ltr" class="text-{{$progress < 100 ? 'danger' : 'success'}} tx-13 ms-2">({{($progress < 100 ? '-' : '').now()->diffInDays($task->target_date)}})</span></h4>
                                    <p class="mb-2 tx-12 text-muted">التاريخ المستهدف</p>
                                </div>

                                @if($task->finished)
                                    <div class="card-chart bg-success-transparent round ms-auto mt-0">
                                        <i class="mdi mdi-check text-success tx-24"></i>
                                    </div>
                                @else
                                    <div class="card-chart bg-warning-transparent round ms-auto mt-0">
                                        <i class="mdi mdi-loading text-warning tx-24"></i>
                                    </div>
                                @endif

                            </div>

                            <div class="progress progress-sm mt-2">
                                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{$progress}}"
                                     class="progress-bar bg-{{getTaskProgressBG($progress)}} wd-{{$progress}}p" role="progressbar"></div>
                            </div>

                            <small class="mb-0 text-muted">معدل الانجاز<span class="float-end text-muted">{{getTaskProgress($task)}}%</span></small>
                        </div>

                        <div class="card-footer p-0 d-flex">
                            <button style="border-radius: 0 0 10px 0" class="btn btn-sm btn-primary edit-{{$singleModel}}-btn" data-bs-toggle="modal"
                                    data-bs-target="#add-edit-{{$pluralModel}}"><i class="fa fa-edit"></i> تعديل المهمة
                            </button>

                            <form action="{{dashboard_route('tasks.destroy', $task->id)}}" method="post" class="d-inline">
                                @csrf
                                @method('delete')

                                <button type="submit" class="btn btn-sm btn-danger delete" style="width:100%;border-radius: 0 0 0 10px;"><i
                                        class="fa fa-trash"></i> حذف المهمة
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    @endif
    <!-- Row -->

    <!-- End Row -->
@endsection

@push('scripts')

    <!-- Include Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <script>
        $(document).ready(function () {

            const AddModelBtn = $('#add-{{$singleModel}}-btn');
            const EditModelBtn = '.edit-{{$singleModel}}-btn';
            const AddEditModelModal = $('#add-edit-{{$pluralModel}}');

            AddModelBtn.on('click', function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                $.get('{{dashboard_route('tasks.create')}}').done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });

            $('body').on('click', EditModelBtn, function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('.card').attr('id')

                let url = '{{dashboard_route('tasks.edit', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });
        });
    </script>
@endpush
