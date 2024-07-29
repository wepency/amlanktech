<form method="post" action="{{$url}}" id="agenda-form">
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
                <label for="summernote" class="required">محضر الاجتماع</label>
                <textarea id="summernote" name="content">{!! old('content') ?? $agenda?->content !!}</textarea>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-success" id="export-agenda"><i class="fa fa-download"></i>تصدير </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<form method="post" class="d-none" action="{{dashboard_route('meetings.agenda.export', $meeting->id)}}" id="agenda-export">
    @csrf

    <input type="hidden" id="meeting_content" name="content" value="" />
</form>

<script>
    $('#summernote').summernote({
        placeholder: 'برجاء ادخال النص هنا ...',
        tabsize: 2,
        height: 200
    });

    $('#export-agenda').on('click', function() {
        $('#meeting_content').val($('#summernote').val());
        $('#agenda-export').submit();
    });
</script>
