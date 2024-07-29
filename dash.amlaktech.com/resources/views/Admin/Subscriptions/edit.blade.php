<form method="post" action="{{route('dashboard.subscriptions.update',['subscription'=>$subscription->id])}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">تعديل الاشتراك  </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')
            @method('PUT')
        
            <div class="form-group">
                <label for="add-title">  الجمعيه </label>
                <select class="form-select"  name="association_id">
                    @foreach($associations as $association)
                        <option value="{{$association->id}}"  {{ old('association_id', $association->id) == $association->id ? 'selected' : '' }}>
                            {{$association->name}}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <div class="form-group">
                <label for="add-title">  الوحدة  </label>
                <select class="form-select"  name="unit_id">
                    @foreach($units as $unit)
                        <option value="{{$unit->id}}"  {{ old('unit_id', $unit->id) == $unit->id ? 'selected' : '' }}>
                            {{$unit->name}}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <div class="form-group">
                <label for="add-title"> نوع الاشتراك </label>
                <select class="form-select"  name="subscription_type_id">
                    @foreach($subscriptionTypes as $subscriptionType)
                        <option value="{{$subscriptionType->id}}"  {{ old('subscription_type_id', $subscriptionType->id) == $subscriptionType->id ? 'selected' : '' }}>
                            {{$subscriptionType->name_en}}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <div class="form-group">
                <label for="add-start_payment"> تاريخ بداية الدفع </label>
                <input type="date" class="form-control" id="add-start_payment" name="start_payment" value="{{old('start_payment')  ?? $subscription->start_payment??''}}" />
            </div>

            <div class="form-group">
                <label for="add-end_payment"> تاريخ بداية الدفع </label>
                <input type="date" class="form-control" id="add-end_payment" name="end_payment" value="{{old('end_payment')  ?? $subscription->end_payment??''}}" />
            </div>


            
            <div class="form-group">
                <label for="add-title">  الدفع </label>
                <select class="form-select"  name="is_paid">
                        <option value="1" > تم الدفع</option>
                        <option value="0" >لم يدفع</option>
                </select>
            </div>
        </div>


        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> تعديل الاشتراك  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>