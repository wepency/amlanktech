<form method="post" action="{{route('dashboard.associations.update',['association'=>$association->id])}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')
            @method('PUT')
            <div class="form-group">
                <label for="add-name">اسم الجمعية <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="add-name" name="name" value="{{old('name') ?? $association->name}}" required />
            </div>


            <div class="form-group">
                <label for="add-map_link"> (google map link) موقع الجمعية<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="add-map_link" name="map_link" value="{{old('map_link') ?? $association->map_link}}" required />
            </div>

            <div class="form-group">
                <label for="add-registration_number"> رقم تسجيل الجمعية <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="add-registration_number" name="registration_number" value="{{old('registration_number') ?? $association->registration_number}}" required />
            </div>

            <div class="form-group">
                <label for="add-unit_fee_per_meter"> رسوم اشتراك الوحدة لكل متر</label>
                <input type="text" class="form-control" id="add-unit_fee_per_meter" name="unit_fee_per_meter" value="{{old('unit_fee_per_meter')  ?? $association->unit_fee_per_meter }}"  />
            </div>

            <div class="form-group">
                <label for="add-family_fee"> رسوم اشتراك الاسرة  </label>
                <input type="text" class="form-control" id="add-family_fee" name="family_fee" value="{{old('family_fee')  ?? $association->family_fee }}" />
            </div>

            <div class="form-group">
                <label for="add-person_fee"> رسوم اشتراك الفرد  </label>
                <input type="text" class="form-control" id="add-person_fee" name="person_fee" value="{{old('person_fee')  ?? $association->person_fee }}" />
            </div>

            <div class="form-group">
                <label for="add-car_fee"> رسوم اشتراك السيارة  </label>
                <input type="text" class="form-control" id="add-car_fee" name="car_fee" value="{{old('car_fee')  ?? $association->car_fee }}" />
            </div>

            <div class="form-group">
                <label for="add-registration_certificate" class="form-label">شهادة تسجيل الجمعية <span class="text-danger">*</span></label>
                <input class="form-control" type="file" id="add-registration_certificate" name="registration_certificate">
            </div>


            <div class="form-group">
                <label for="add-title"> مدير الجمعيه <span class="text-danger">*</span> </label>
                <select class="form-select"  name="admin_id">
                    @foreach($admins as $admin)
                        <option value="{{$admin->id}}" {{ old('admin_id', $admin->id) == $admin->id ? 'selected' : '' }}>
                            {{$admin->name}}
                        </option>
                    @endforeach
                </select>
            </div>

             <h6>-----------------------------------------------------------------------------</h6>
            <h5 >تعديل عنوان الجمعية</h5>

            <div class="form-control">

                <div class="form-group">
                    <input type="text" placeholder="Official Mail" class="form-control" id="add-official_mail" name="official_mail" value="{{old('official_mail')  ?? $association->address->country??'' }}"  />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Address Mail" class="form-control" id="add-address_mail" name="address_mail" value="{{old('address_mail')  ?? $association->address->country??'' }}"  />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Box Mail" class="form-control" id="add-box_mail" name="box_mail" value="{{old('box_mail')  ?? $association->address->country??'' }}"  />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Country" class="form-control" id="add-country" name="country" value="{{old('country')  ?? $association->address->country??'' }}" />
                </div>



                <div class="form-group">
                    <input type="text" placeholder="Province" class="form-control" id="add-province" name="province" value="{{old('province')  ?? $association->address->province??'' }}" />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Region" class="form-control" id="add-region" name="region" value="{{old('region')  ?? $association->address->region??'' }}" />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Street" class="form-control" id="add-street" name="street" value="{{old('street')  ?? $association->address->street??'' }}" />
                </div>

                <div class="form-group">
                    <input type="text" placeholder="Building" class="form-control" id="add-building" name="building" value="{{old('building')  ?? $association->address->building??'' }}" />
                </div>

            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> تعديل الجمعية  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
