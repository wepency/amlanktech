<div class="tab-pane registration-tab fade" id="registration-tab" role="tabpanel">

    <form action="{{route('member.unit.request')}}" method="post">
        @csrf

        <h3 class="item-title">تقديم طلب عضوية</h3>

        <div class="form-group">
            <input id="name" type="text" value="{{old('name')}}" name="name" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" placeholder="الاسم*">

            @if($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="phone_number" type="text" value="{{old('phone_number')}}" name="phone_number" class="form-control {{$errors->has('phone_number') ? 'is-invalid' : ''}}" placeholder="رقم الجوال*">

            @if($errors->has('phone_number'))
                <p class="text-danger">{{$errors->first('phone_number')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="email" type="email" value="{{old('email')}}" name="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" placeholder="البريد الإلكتروني*">

            @if($errors->has('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="password" type="password" name="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" placeholder="كلمة المرور*">

            @if($errors->has('password'))
                <p class="text-danger">{{$errors->first('password')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="password" type="password" name="password_confirmation" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" placeholder="تأكيد كلمة المرور*">

            @if($errors->has('password_confirmation'))
                <p class="text-danger">{{$errors->first('password_confirmation')}}</p>
            @endif
        </div>

        <h3 class="item-title">بيانات الوحدة</h3>

        <div class="form-group">
            <select class="form-control select2 {{$errors->has('association_id') ? 'is-invalid' : ''}}" id="association_id" name="association_id" data-placeholder="اختر الجمعية*">
                <option value=""></option>

                @foreach($associations as $association)
                    <option
                        value="{{$association->id}}" {{old('association_id') == $association->id ? 'selected' : ''}}>{{$association->name}}</option>
                @endforeach

            </select>

            @if($errors->has('association_id'))
                <p class="text-danger">{{$errors->first('association_id')}}</p>
            @endif
        </div>

        <div class="form-group d-none" id="association_fees_amount">
            <p style="max-width:340px" class="text text-muted text-black"></p>
            <input id="fee_type_amount" type="number" name="fee_type_amount" value="{{old('fee_type_amount')}}" class="form-control {{$errors->has('fee_type_amount') ? 'is-invalid' : ''}}" placeholder="برجاء ادخال القيمة*" required />

            @if($errors->has('fee_type_amount'))
                <p class="text-danger">{{$errors->first('fee_type_amount')}}</p>
            @endif
        </div>

        <div class="form-group">
            <select class="form-control select2 {{$errors->has('ownership_type') ? 'is-invalid' : ''}}" id="ownership_type" name="ownership_type" data-placeholder="العقار يتبع لفرد أو مجموعة؟*" required>

                <option value=""></option>

                <option
                    value="individual" {{old('ownership_type') == 'individual' ? 'selected' : ''}}>
                    فرد
                </option>

                <option value="group" {{old('ownership_type') == 'group' ? 'selected' : ''}}>
                    مجموعة
                </option>

            </select>

            @if($errors->has('ownership_type'))
                <p class="text-danger">{{$errors->first('ownership_type')}}</p>
            @endif
        </div>

        <div class="form-group {{old('ownership_type') == 'group' ? 'd-block' : 'd-none'}}" id="ownership_ratio_group">
            <input id="ownership_ratio" value="{{old('ownership_ratio')}}" type="number" min="0" max="100" name="ownership_ratio" class="form-control {{$errors->has('ownership_ratio') ? 'is-invalid' : ''}}" placeholder="نسبة الشراكة" />

            @if($errors->has('ownership_ratio'))
                <p class="text-danger">{{$errors->first('ownership_ratio')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="address" value="{{old('address')}}" type="text" name="address" class="form-control {{$errors->has('address') ? 'is-invalid' : ''}}" placeholder="عنوان الوحدة*"/>

            @if($errors->has('address'))
                <p class="text-danger">{{$errors->first('address')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="water_meter_serial" value="{{old('water_meter_serial')}}" type="text"
                   name="water_meter_serial" class="form-control {{$errors->has('water_meter_serial') ? 'is-invalid' : ''}}"
                   placeholder="رقم عداد المياة*" />

            @if($errors->has('water_meter_serial'))
                <p class="text-danger">{{$errors->first('water_meter_serial')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="electricity_meter_serial" value="{{old('electricity_meter_serial')}}"
                   type="text" name="electricity_meter_serial" class="form-control {{$errors->has('electricity_meter_serial') ? 'is-invalid' : ''}}"
                   placeholder="رقم عداد الكهرباء*"/>

            @if($errors->has('electricity_meter_serial'))
                <p class="text-danger">{{$errors->first('electricity_meter_serial')}}</p>
            @endif
        </div>

        <div class="form-group">
            <input id="area" type="number" name="area" value="{{old('area')}}"
                   class="form-control {{$errors->has('area') ? 'is-invalid' : ''}}"
                   placeholder="مساحة الوحدة*"
            />

            @if($errors->has('area'))
                <p class="text-danger">{{$errors->first('area')}}</p>
            @endif
        </div>


        <div class="form-group">
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="validationFormCheck" name="accept-terms" {{old('accept-terms') == 'on' ? 'checked' : ''}} />
                <label class="form-check-label" for="validationFormCheck">انا أوافق على <a href="#">الشروط والأحكام.</a></label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" name="registration" id="registration-btn" class="submit-btn">تقديم طلب الانضمام</button>
        </div>

    </form>
</div>
