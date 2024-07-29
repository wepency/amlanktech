<form method="post" action="{{$url}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @if($association->exists)
                @method('PUT')
            @endif

            @include('messages')

            <div class="form-group">
                <label for="add-name">اسم الجمعية <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="add-name" name="name"
                       value="{{old('name') ?? $association?->name}}" required/>
            </div>

            <div class="form-group">
                <label for="add-map_link" class="required"> (google map link) موقع الجمعية </label>
                <input type="text" class="form-control" id="add-map_link" name="map_link"
                       value="{{old('map_link') ?? $association?->map_link}}" required/>
            </div>

            <div class="form-group">
                <label for="address" class="required">العنوان</label>
                <input type="text" class="form-control" name="address" id="address"
                       value="{{old('address') ?? $association?->address}}" required/>
            </div>

            <div class="form-group">
                <label for="add-registration_number" class="required"> رقم تسجيل الجمعية </label>
                <input type="text" class="form-control" id="add-registration_number" name="registration_number"
                       value="{{old('registration_number') ?? $association?->registration_number}}" required/>
            </div>

            <div class="form-group">
                <label for="subscription_period" class="required"> مدة الاشتراك </label>

                <select class="form-control" id="subscription_period" name="subscription_period">
                    <option value="1" {{$association->subscription_period == 1 ? 'selected' : ''}}>شهري</option>
                    <option value="3" {{$association->subscription_period == 3 ? 'selected' : ''}}>ثلاثة شهور</option>
                    <option value="6" {{$association->subscription_period == 6 ? 'selected' : ''}}>ستة شهور</option>
                    <option value="12" {{$association->subscription_period == 12 ? 'selected' : ''}}>سنوي</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subscription-start-date" class="required"> تاريخ بداية الاشتراك </label>
                <input type="date" class="form-control" id="subscription-start-date" name="subscription_start_date"
                       value="{{old('subscription_start_date') ?? $association?->subscription_start_date}}"
                       min="{{now()->format('Y-m-d')}}" required/>
            </div>

            <div class="form-group">
                <label for="fees_type" class="required"> نوع الاشتراك </label>

                <select class="form-control" id="fees_type" name="fee_type_id" required>
                    @foreach($fees_types as $fees_type)
                        <option data-label="{{$fees_type->label}}"
                                value="{{$fees_type?->id}}" {{$association->fee_type_id ==  $fees_type?->id ? 'selected' : ''}}>{{$fees_type?->type}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label id="fee_amount_label" class="required" for="add-fee_amount"> سعر المتر المربع </label>
                <input type="text" class="form-control" id="add-fee_amount" name="fee_amount"
                       value="{{old('fee_amount') ?? $association?->fee_amount}}" required/>
            </div>

            <div class="form-group">
                <label for="add-registration_certificate" class="form-label">شهادة تسجيل الجمعية </label>
                <input class="form-control" type="file" id="add-registration_certificate"
                       name="registration_certificate">
            </div>

            <div class="form-group">
                <label for="admin_id"> رئيس الجمعية </label>

                <select class="form-select" id="admin_id" name="admin_id" data-placeholder="اختر رئيس الجمعية">
                    <option></option>

                    @foreach($admins as $admin)
                        <option value="{{$admin->id}}" {{$association->admin_id ==  $admin?->id ? 'selected' : ''}}>
                            {{$admin->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(!$association->exists)
                <div id="manager-form"></div>
                <button type="button" class="btn btn-success" id="toggle-manager-form">

                <span class="show-manager">
                    <i class="fa fa-plus"></i> <span>اضافة مدير</span>
                </span>

                    <span class="hide-manager">
                    <i class="fa fa-minus"></i> <span>إزالة</span>
                </span>

                </button>
            @endif

            <script>
                $(document).ready(function () {

                    $('#admin_id').select2({
                        dropdownParent: $('.modal-body'),
                        allowClear: true,
                    });

                    $('#toggle-manager-form').click(function (e) {
                        e.preventDefault();

                        if($(this).hasClass('manager-on')) {
                            $('#manager-form').empty();
                            $(this).removeClass('manager-on').removeClass('btn-danger').addClass('btn-success');
                        }else {
                            $(this).addClass('manager-on').removeClass('btn-success').addClass('btn-danger');

                            $.get('{{dashboard_route('associations.managers.create')}}', function (data) {
                                $('#manager-form').html(data.data)
                            })
                        }
                    })
                })
            </script>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
