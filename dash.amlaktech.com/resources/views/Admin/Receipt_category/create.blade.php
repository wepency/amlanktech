<form method="post" action="{{$url}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($model->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name" class="required">التصنيف </label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{old('name') ?? $model->name}}" required/>
            </div>

            <div class="form-group">
                <label for="receipt_type" class="required">النوع</label>

                <select name="receipt_type" id="receipt_type" class="form-control">
                    <option value="income" {{$model->receipt_type == 'income' ? 'selected' : ''}}>سند قبض</option>
                    <option value="payment" {{$model->receipt_type == 'payment' ? 'selected' : ''}}>سند صرف</option>
                </select>
            </div>

            @if(is_admin())
                <div class="form-group" id="association-all">
                    <label for="association_id" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', ['currentValue' => $model->association_id])
                </div>
            @endif

            <div class="form-group">
                <label for="requires_approval">جعل السند مقيد</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="requires_approval" name="requires_approval" {{$model->requires_approval == 1 ? 'checked' : ''}} />
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
