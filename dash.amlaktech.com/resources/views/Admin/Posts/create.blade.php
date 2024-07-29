<form method="post" action="{{$url}}" id="bill-id-form" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($post->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title" class="required">عنوان المنشور</label>

                <input type="text" class="form-control" id="title" name="title"
                       value="{{old('name') ?? $post->title}}" required />
            </div>

            <div class="form-group">
                <label for="summernote" class="required">محتوى المنشور</label>
                <textarea id="summernote" name="content">{!! old('content') ?? $post->content !!}</textarea>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>

                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $post->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="is_active">السماح بالنشر</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="is_active" name="is_active" {{$post->is_active ? 'checked' : ''}} />
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>
    $('#summernote').summernote({
        placeholder: 'Enter your text here...',
        tabsize: 2,
        height: 200
    });
</script>
