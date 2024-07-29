<form method="post" action="{{route('dashboard.units.update',['unit'=>$unit->id])}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">تعديل الجمعية  </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf

            @include('messages')
            @method('PUT')
        
            <div class="form-group">
                <label for="add-name">اسم الوحدة  </label>
                <input type="text" class="form-control" id="add-name" name="name" value="{{old('name') ?? $unit->name}}" required />
            </div>

            <div class="form-group">
                <label for="add-unit_number">رقم الوحدة  </label>
                <input type="text" class="form-control" id="add-unit_number" name="unit_number" value="{{old('unit_number') ?? $unit->unit_number}}" required />
            </div>

            <div class="form-group">
                <label for="add-instrument_number">  رقم الصك الملكية </label>
                <input type="text" class="form-control" id="add-instrument_number" name="instrument_number" value="{{old('instrument_number') ?? $unit->instrument_number}}" required />
            </div>

            <div class="form-group">
                <label for="add-instrument_file" class="form-label">شهادة الصك الملكية </label>
                <input class="form-control" type="file" id="add-instrument_file" name="instrument_file">
            </div>

            <div class="form-group">
                <label for="add-meter_price"> سعر المتر بالوحدة </label>
                <input type="text" class="form-control" id="add-meter_price" name="meter_price" value="{{old('meter_price') ?? $unit->meter_price}}"  />
            </div>

            <div class="form-group">
                <label for="add-area"> مساحة الوحدة </label>
                <input type="text" class="form-control" id="add-area" name="area" value="{{old('area') ?? $unit->area}}"  />
            </div>

            <div class="form-group">
                <label for="add-unit_memebers">  عدد الافراد بالوحدة </label>
                <input type="text" class="form-control" id="add-unit_memebers" name="unit_memebers" value="{{old('unit_memebers') ?? $unit->unit_memebers}}" />
            </div>

            <div class="form-group">
                <label for="add-unit_families"> عدد الأسر بالوحدة </label>
                <input type="text" class="form-control" id="add-unit_families" name="unit_families" value="{{old('unit_families') ?? $unit->unit_families}}" />
            </div>

            <div class="form-group">
                <label for="add-car_numbers">   عد السيارات بالوحده  </label>
                <input type="text" class="form-control" id="add-car_numbers" name="car_numbers" value="{{old('car_numbers') ?? $unit->car_numbers}}" />
            </div>
            
            <div class="form-group">
                <label for="add-notes">   ملاحظات  </label>
                <input type="text" class="form-control" id="add-notes" name="notes" value="{{old('notes') ?? $unit->notes}}" />
            </div>

            <div class="form-group">
                <label for="add-title">  مالك الوحدة  </label>
                <select class="form-select"  name="association_member_id">
                    @foreach($members as $member)
                        <option value="{{$member->id}}"  {{ old('association_member_id', $member->id) == $member->id ? 'selected' : '' }}>
                            {{$member->name}}
                        </option>
                    @endforeach                        
                </select>
            </div>          
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> تعديل الوحدة  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div> 
</form>