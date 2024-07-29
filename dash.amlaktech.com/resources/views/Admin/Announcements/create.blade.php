<form method="post" action="{{$url}}" id="bill-id-form">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($announcement->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title">عنوان الاعلان <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{old('title') ?? $announcement->title}}" required/>
            </div>

            <div class="form-group">
                <label for="body">محتوى الاعلان <span class="text-danger">*</span></label>
                <textarea class="form-control" id="body" name="body" required>{{old('body') ?? $announcement->body}}</textarea>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $announcement->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="add-active">نشر الاعلان</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="add-active" name="status" {{$announcement->status == 1 ? 'checked' : ''}} />
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
    $(document).ready(function () {
        $('.select2').select2();

        $('#body').summernote({
            height: 300, // set the height of the editor
            // Add any other configurations or callbacks as needed
        });
    })
</script>
