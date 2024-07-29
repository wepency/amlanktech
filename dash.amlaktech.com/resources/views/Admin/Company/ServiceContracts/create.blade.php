<form method="post" action="{{$url}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($service->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="service_type">نوع العقد <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="add-service_type" name="service_type"
                       value="{{old('service_type') ?? $service->service_type}}" required/>
            </div>

            <div class="form-group">
                <label for="amount">  الكمية <span class="text-danger">*</span> </label>
                <input type="number" class="form-control" id="amount" name="amount"
                       value="{{old('amount') ?? $service->amount}}" required/>
            </div>

            <div class="form-group">
                <label for="add-contract_file" class="form-label">  العقد</label>
                <input class="form-control" type="file" id="add-contract_file" name="contract_file">
            </div>

            
            <h5 > اختر الشركة </h5>

            <div class="form-group">
                <select class="form-select"  name="company_id">
                    @foreach($companies as $company)
                        <option value="{{$company->id}}" {{ old('company_id', $company->id) == $company->id ? 'selected' : '' }}>
                            {{$company->name}}
                        </option>
                    @endforeach                        
                </select>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
