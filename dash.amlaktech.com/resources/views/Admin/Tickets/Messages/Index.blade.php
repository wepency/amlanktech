@extends('Admin.Layouts.Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{asset('assets/back/plugins/fancyuploder/fancyuploder/fancy_fileupload.css')}}">
@endsection

@section('content')
    <!-- User Modal -->
    <div class="modal fade" id="add-ticket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="{{route('dashboard.messages.store' , [$ticket->id])}}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اضافة رسالة جديدة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @csrf

                        @include('messages')

                        <div class="form-group">
                            <label for="add-body">الرسالة  </label>
                            <input type="textarea" class="form-control" id="add-body" name="body" value="{{old('body')}}" required />
                        </div>

                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">

                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> اضافة رسالة  </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @foreach($messages as $message)
        <div class="modal fade" id="edit-ticket-{{$message->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="{{route('dashboard.messages.update',  ['ticket' => $ticket->id, 'message' => $message->id])}}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">تعديل الرسالة </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="edit-title-{{$message->id}}">الاسم</label>
                                <input type="text" class="form-control" id="edit-body-{{$message->id}}" name="body" value="{{old('body') ?? $message->body}}" required />
                            </div>

                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                    
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                    
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> تعديل الرسالة  </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المحتوى</h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">/ {{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-ticket" class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>

            <span class="btn btn-primary mb-1 me-1">
                <span>عدد الرسائل</span>
                <span class="badge  bg-white ms-1">{{$messages->count()}}</span>
            </span>

            <a href="{{route('dashboard.tickets.index' )}}" class="btn btn-danger mb-1 me-1" data-toggle="tooltip" title="العودة للتذاكر">
                <span class="me-1">العودة للتذاكر </span>
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
                    <h3 class="card-title">المواد</h3>
                </div>

                <div class="card-body pt-0">

                        <div class="table-responsive">
                            <table class="table table-striped mg-b-0 text-md-nowrap dl-table" id="basic-datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="wd-3p border-bottom-0"> الرسالة </th>
                                    <th class="border-bottom-0">التذكرة</th>
                                    <th class="border-bottom-0">الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$message->body}}</td>
                                        <td>
                                            <img src="{{ asset($message->image) }}" width="100px" height="100px" alt="Ticket Image">


                                        </td>
                                        <td>{{$message->ticket->title}}</td>


                                        <td>
                                            <!-- Edit -->
                                            <button type="button" class="btn btn-primary" data-toggle="tooltip" title="تعديل" data-bs-toggle="modal" data-bs-target="#edit-message-{{$message->id}}"><i class="far fa-edit"></i></button>

                                            <!-- Delete -->
                                            <form method="post" action="{{route('dashboard.messages.destroy',  ['ticket' => $ticket->id, 'message'=>$message->id])}}" style="display:inline-block;margin:0">
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
    <!-- Internal Fileuploads js -->
    <script src="{{asset('assets/back/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{asset('assets/back/plugins/fileuploads/js/file-upload.js')}}"></script>
@endsection
