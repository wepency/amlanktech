<form method="post" action="{{$url}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($policy->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="add-name">الاسم <span class="text-danger">*</span></label>

                <input type="text" class="form-control" id="add-name" name="name"
                       value="{{old('name') ?? $policy->name}}" required/>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $policy->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="add-policy_file" class="required"> اللائحة </label>
                <input class="form-control" type="file" id="add-policy_file" name="policy_file">
            </div>

            <div class="form-group">
                <label for="notes" class="form-label"> معلومات إضافية </label>
                <textarea class="form-control" type="file" id="notes" name="notes">{{$policy->notes}}</textarea>
            </div>

            <div class="form-group">
                <label for="add-active">نشر اللائحة</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="add-active" name="status" {{$policy->status == 1 ? 'checked' : ''}} />
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

        $('#notes').summernote({
            height: 300, // set the height of the editor
            // Add any other configurations or callbacks as needed
        });
    });
</script>
