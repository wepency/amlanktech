<form method="post" action="{{route('dashboard.subscriptions.store')}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">اضافة اشتراك  جديدة</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            <div class="form-group">
                <label for="add-title">  الجمعيه </label>
                <select class="form-select"  name="association_id">
                    @foreach($associations as $association)
                        <option value="{{$association->id}}">
                            {{$association->name}}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <div class="form-group">
                <label for="add-title">  الوحدة  </label>
                <select class="form-select"  name="unit_id">
                    @foreach($units as $unit)
                        <option value="{{$unit->id}}">
                            {{$unit->unit_no}}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <div class="form-group">
                <label for="add-title"> نوع الاشتراك </label>
                <select class="form-select"  name="subscription_type_id">
                    @foreach($subscriptionTypes as $subscriptionType)
                        <option value="{{$subscriptionType->id}}">
                            {{$subscriptionType->name_en}}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <div class="form-group">
                <label for="add-start_payment"> تاريخ بداية الدفع </label>
                <input type="date" class="form-control" id="add-start_payment" name="start_payment" value="{{old('start_payment')}}" />
            </div>

            <div class="form-group">
                <label for="add-end_payment"> تاريخ بداية الدفع </label>
                <input type="date" class="form-control" id="add-end_payment" name="end_payment" value="{{old('end_payment')}}" />
            </div>

            <div class="form-group">
                <label for="add-title">  الدفع </label>
                <select class="form-select"  name="is_paid">
                        <option value="1"> تم الدفع</option>
                        <option value="0">لم يدفع</option>
                </select>
            </div>
           
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> اضافة الاشتراك  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>