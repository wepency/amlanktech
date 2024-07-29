<form method="post" action="{{$url}}" id="bill-id-form">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($bill->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">الاسم <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="add-name" name="name"
                       value="{{old('name') ?? $bill->name}}" required/>
            </div>

            <div class="form-group">
                <label for="date-picker">التاريخ</label>
                <input type="date" class="form-control" id="date-picker" name="date"
                       value="{{old('date') ?? $bill->date}}" required/>
            </div>

            @if(!is_manager())
                <div class="form-group">
                    <label for="association_id">الجمعية <span class="text-danger">*</span></label>
                    <select class="form-control" id="association_id" name="association_id" required>
                        <option value="">اختر الجمعية</option>

                        @foreach($associations as $association)
                            <option value="{{$association->id}}"
                                    @if($bill->association_id == $association->id) selected @endif>{{$association->name}}</option>
                        @endforeach
                    </select>

                </div>
            @endif

            <div class="form-group">
                <label for="value"> المبلغ<span class="text-danger">*</span> </label>
                <input type="number" step="0.1" class="form-control" id="value" name="value"
                       value="{{old('value') ?? $bill->value}}" required/>
            </div>

            <div class="form-group">
                <label for="notes">ملاحظات</label>
                <textarea class="form-control" id="notes" name="notes"
                          rows="3">{{old('notes') ?? $bill->notes}}</textarea>
            </div>

            <div class="form-group">
                <label for="repeated">يتكرر شهريا</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="repeated" name="repeated" {{$bill->repeated ? 'checked' : ''}} />
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
