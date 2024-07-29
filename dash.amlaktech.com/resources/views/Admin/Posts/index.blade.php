@extends('Admin.Layouts.Dashboard')

@push('styles')
    <!-- Include Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')

    <!-- Add / Edit Posts group -->
    <div class="modal fade" id="add-edit-{{$pluralModel}}" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Post likes -->
    <div class="modal fade" id="likes" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <!-- Post comments -->
    <div class="modal fade" id="comments" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- All Posts statics -->
    @include('Admin.Posts._statics')

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$page_title}}</h3>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table id="data-table"
                               class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
                            <thead>

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">صورة المنشور</th>
                                <th scope="col">عنوان المنشور</th>
                                @if(is_admin())
                                    <th scope="col">الجمعية</th>
                                @endif
                                <th scope="col">اعجابات</th>
                                <th scope="col">اعتراضات</th>
                                <th scope="col">التعليقات</th>

                                <th scope="col">اجراءات</th>
                            </tr>

                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            const ShowCommentsModal = $('#comments');
            const ShowLikesModal = $('#likes');

            AddModelBtn.on('click', function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                $.get('{{dashboard_route('posts.create')}}').done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });

            $('body').on('click', EditModelBtn, function (e) {
                e.preventDefault();
                AddEditModelModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('posts.edit', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    AddEditModelModal.find('.modal-dialog').html(data.data);
                });
            });

            // Open links
            $('body').on('click', '.open-likes', function (e) {
                e.preventDefault();
                ShowLikesModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('posts.likes', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    ShowLikesModal.find('.modal-dialog').html(data.data);
                });
            });

            $('body').on('click', '.open-dislikes', function (e) {
                e.preventDefault();
                ShowLikesModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('posts.dislikes', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    ShowLikesModal.find('.modal-dialog').html(data.data);
                });
            });

            // Open dislikes
            $('body').on('click', '.open-dislikes', function (e) {
                e.preventDefault();
                ShowCommentsModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('posts.dislikes', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    ShowCommentsModal.find('.modal-dialog').html(data.data);
                });
            });

            // Open comments
            $('body').on('click', '.open-comments', function (e) {
                e.preventDefault();
                ShowCommentsModal.find('.modal-dialog').html(getPreloader());

                const id = $(this).parents('tr').attr('id')

                let url = '{{dashboard_route('posts.comments', ':id')}}';
                url = url.replace(':id', id)

                $.get(url).done(function (data) {
                    ShowCommentsModal.find('.modal-dialog').html(data.data);
                });
            });

            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ dashboard_route('posts.index') }}",
                    "dataSrc": function (json) {
                        $('#posts-total').text(json.total)
                        $('#reacts-total').text(json.totalReactions)
                        $('#comments-total').text(json.totalComments)

                        return json.data;
                    }
                },
                language: {
                    searchPlaceholder: 'بحث ...',
                    scrollX: "100%",
                    sSearch: '',
                    info: "عرض الصفحة _PAGE_ من _PAGES_",
                    lengthMenu: '_MENU_ عقار/صفحة'
                },
                columns: [
                    {data: 'id', name: 'id', orderable: true, searchable: false},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'title', name: 'title', orderable: true, searchable: true},
                        @if(is_admin())
                    {
                        data: 'association', name: 'association', orderable: true, searchable: false
                    },
                        @endif
                    {data: 'likes', name: 'likes', orderable: true, searchable: false},
                    {data: 'dislikes', name: 'dislikes', orderable: true, searchable: false},
                    {data: 'comments', name: 'comments', orderable: true, searchable: false},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},

                ],
                responsive: true,
                order: [0, 'desc']
            });
        });
    </script>
@endpush
