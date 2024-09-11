<form id="create-association" method="post" action="{{$url}}" enctype="multipart/form-data">
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

                       @if(!$association->exists)
                           min="{{now()->format('Y-m-d')}}"
                       @endif

                       required/>
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
                <label for="admin_id" class="required"> رئيس الجمعية </label>

                <div class="form-group">
                    <select name="admin_id" id="admin_id" class="select2 w-100">
                        @if($association->exists && $association?->admin)
                            <option value="{{$association->admin_id}}">{{$association?->admin?->name . ' - ' . $association?->admin?->phone_number}}</option>
                        @endif
                    </select>
                </div>
            </div>

            <script>
                $(document).ready(function () {

                    // Handle Select2 change event
                    $('#admin_id').select2({
                        allowClear: true,
                        placeholder: 'برجاء اختيار رئيس الجمعية',
                        ajax: {
                            url: '/admin/api/admins', // URL to fetch current users
                            dataType: 'json',
                            processResults: function (data) {
                                let results = data.map(function (user) {
                                    return {
                                        id: user.id,
                                        text: user.name
                                    };
                                });
                                // Add "Add New User" option
                                results.unshift({
                                    id: 'add-new',
                                    text: '+ اضافة رئيس جمعية'
                                });
                                return {
                                    results: results
                                };
                            }
                        }
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
