<form method="post" action="{{$url}}" id="decisions-form">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf
            @method('PUT')

            @include('messages')

            <div class="form-group">
                <label for="content" class="required">قرارات الاجتماع</label>
                <textarea id="content" name="content">{!! old('content') ?? $decisions?->content !!}</textarea>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>
    $('#content').summernote({
        placeholder:  'برجاء ادخال النص هنا ...',
        tabsize: 2,
        height: 200
    });
</script>
