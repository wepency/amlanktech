<form method="post" action="{{$url}}" id="bill-id-form" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($receipt->exists)
                @method('PUT')
            @endif

            <label for="receipt-no">رقم السند: {{$receipt->id ?? '###'}}</label>

            <div class="form-group">
                <label for="title">من أجل <span class="text-danger">*</span></label>

                <input type="text" class="form-control" id="title" name="title"
                       value="{{old('title') ?? $receipt->title}}" required/>
            </div>

            @if(!is_admin())
                <div class="form-group">
                    <label for="manager">أمين الصندوق</label>

                    <input type="text" class="form-control" id="manager" name="manager"
                           value="{{$manager?->name}}" disabled readonly/>
                </div>
            @endif

            <div class="form-group">
                <label for="date-picker">التاريخ</label>

                <input type="date" class="form-control" id="date-picker" name="date"
                       value="{{old('date') ?? $receipt->date}}" required/>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>

                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $receipt->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="receipt_category_id">نوع السند</label>

                <select class="form-select select2" id="receipt_category_id" name="receipt_category_id">
                    <option value="">اختر نوع السند</option>

                    @foreach($categories as $category)
                        <option
                            value="{{$category?->id}}" {{$receipt->receipt_category_id == $category?->id ? 'selected' : ''}}>{{$category?->name . ($category->requires_approval ? ' (مقيد)' : '')}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="amount" class="required"> المبلغ</label>
                <input type="number" step="0.1" class="form-control" id="amount" name="amount"
                       value="{{old('amount') ?? $receipt->amount}}" required/>
            </div>

            <div class="form-group">
                <label for="payment_type">الدفع عن طريق</label>

                <select class="form-select select2" id="payment_type" name="payment_type">
                    <option value="cash" {{$receipt->payment_type == 'cash' ? 'selected' : ''}}>كاش</option>
                    <option value="bank" {{$receipt->payment_type == 'bank' ? 'selected' : ''}}>بنك</option>
                </select>
            </div>

            <div class="form-group">
                <label for="notes"> ملاحظات </label>
                <textarea class="form-control" type="file" id="notes" name="notes">{{$receipt->notes}}</textarea>
            </div>

            {{--            <div class="input-group mb-3">--}}
            {{--                <input type="file" class="form-control" id="image" name="image">--}}
            {{--            </div>--}}


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
    });
</script>
