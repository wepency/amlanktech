<form method="post" id="unit-id-form" action="{{$url}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @if($unit->exists)
                @method('PUT')
            @endif

            @include('messages')

            @if(!is_manager())
                <div class="form-group">
                    <label for="association_id" class="required">الجمعية </label>

                    <select class="form-control" id="association_id" name="association_id" required>
                        <option value="">اختر الجمعية</option>

                        @foreach($associations as $association)
                            <option
                                value="{{$association->id}}" {{$unit->association_id == $association->id ? 'selected' : ''}}>{{$association->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div id="fee_type_amount_group" class="form-group d-none">
                <label for="fee_type_amount" id="fee_type_amount_label" class="required"></label>
                <input type="text" class="form-control" id="fee_type_amount" name="fee_type_amount"
                       value="{{old('fee_type_amount') ?? $unit?->fee_type_amount}}" required />
            </div>

            <div class="form-group">

                <label for="ownership_type" id="fee_type_amount_label" class="required">العقار يتبع لفرد أو
                    مجموعة</label>

                <select class="form-control select2" id="ownership_type" name="ownership_type" required>

                    <option value="individual" {{$unit->ownership_type == 'individual' ? 'selected' : ''}}>فرد</option>
                    <option value="group" {{$unit->ownership_type == 'group' ? 'selected' : ''}}>مجموعة</option>

                </select>
            </div>

            <div id="partners_amount_group" class="form-group {{$unit->ownership_type == 'group' ? 'd-block' : 'd-none'}}">
                <label for="partners_amount" id="partners_amount">عدد الشركاء</label>
                <input id="partners_amount" value="{{old('partners_amount') ?? $unit->partners_amount}}" type="number" min="0" max="100" name="partners_amount"
                       class="form-control"/>
            </div>

            <div id="ownership_ratio_group" class="form-group {{$unit->ownership_type == 'group' ? 'd-block' : 'd-none'}}">
                <label for="ownership_ratio" id="ownership_ratio">نسبة الشراكة</label>
                <input id="ownership_ratio" value="{{old('ownership_ratio') ?? $unit->ownership_ratio}}" type="number" min="0" max="100" name="ownership_ratio"
                       class="form-control"/>
            </div>

            <div class="form-group">
                <label for="address" class="required">عنوان الوحدة</label>
                <input id="address" value="{{$unit->address}}" type="text" name="address" class="form-control"/>
            </div>

{{--            <div class="form-group">--}}
{{--                <label for="add-unit_number" class="required">رقم الوحدة</label>--}}
{{--                <input type="text" class="form-control" id="add-unit_number" name="unit_number"--}}
{{--                       value="{{old('unit_number')}}" required/>--}}
{{--            </div>--}}

            <div class="form-group">
                <label for="area" class="required">مساحة الوحدة</label>
                <input type="number" class="form-control" id="area" name="area" value="{{old('area') ?? $unit->area}}" required/>
            </div>

            <div class="form-group">
                <label for="water_meter_serial" class="required">رقم عداد المياة</label>
                <input id="water_meter_serial" value="{{$unit->water_meter_serial}}" type="text"
                       name="water_meter_serial" class="form-control" placeholder="رقم عداد المياة" required />
            </div>

            <div class="form-group">
                <label for="electricity_meter_serial" class="required">رقم عداد الكهرباء</label>
                <input id="electricity_meter_serial" value="{{$unit->electricity_meter_serial}}" type="text"
                       name="electricity_meter_serial" class="form-control" placeholder="رقم عداد الكهرباء" required />
            </div>

            <div class="form-group">

                <label for="association_member_id"> مالك الوحدة </label>

                <select class="form-select select2" name="association_member_id" id="association_member_id">

                    <option value="">مالك الوحدة</option>

                    @foreach($members as $member)
                        <option
                            value="{{$member->id}}" {{old('association_member_id') == $member->id ? 'selected' : ($unit->association_member_id == $member->id ? 'selected' : '')}}>{{$member->name .' - '. $member->phone_number}}</option>
                    @endforeach

                </select>
            </div>

            @if(!$unit->exists)

                <div id="member-form"></div>

                <button type="button" class="btn btn-success mt-2 mb-2" id="toggle-member-form">

                <span class="show-member">
                    <i class="fa fa-plus"></i> <span>اضافة مالك</span>
                </span>

                    <span class="hide-member">
                    <i class="fa fa-minus"></i> <span>إزالة</span>
                </span>

                </button>

            @endif

            <div class="form-group">
                <label for="notes"> ملاحظات </label>
                <textarea class="form-control" id="notes" name="notes">{{old('notes') ?? $unit->notes}}</textarea>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>

    @if($unit->exists)
    getAssociationFeesIdentifier('{{$unit->association_id ?? $associations[0]->id}}');
    @endif

    $(document).ready(function () {
        $('#association_id').select2({
            width: '100%',
            placeholder: 'اختر الجمعية',
            allowClear: true,
            dropdownParent: $('#unit-id-form .modal-content')
        });

        $('#toggle-member-form').click(function (e) {
            e.preventDefault();

            if ($(this).hasClass('member-on')) {
                $('#member-form').empty();
                $(this).removeClass('member-on').removeClass('btn-danger').addClass('btn-success');
            } else {
                $(this).addClass('member-on').removeClass('btn-success').addClass('btn-danger');

                $.get('{{dashboard_route('associations.member.create')}}', function (data) {
                    $('#member-form').html(data.data)
                })
            }
        })

        $('#association_member_id').select2({
            allowClear: true,
            width: '100%',
            dropdownParent: $('.modal-content')
        });
    });

    $('#association_id').on('change', function () {
        getAssociationFeesIdentifier($(this).val());
    });

    function getAssociationFeesIdentifier(association_id = null) {
        const FeeTypeGroup = $('#fee_type_amount_group');

        if(association_id !== null) {

            $.get("{{route('dashboard.units.get_association_fees_identifier')}}", {
                association_id: $('#association_id').val() ?? association_id,
            }, function (data) {
                $('#fee_type_amount_label').text(data.data);
                FeeTypeGroup.removeClass('d-none');
            });

        }else {
            FeeTypeGroup.addClass('d-none');
        }

    }

    // ownership_type

    $('#ownership_type').on('change', function () {
        getOwnershipTypeIdentifier();
    })

    function getOwnershipTypeIdentifier() {
        const ownershipType = $('#ownership_type').val()

        if(ownershipType === 'group') {
            $('#partners_amount_group, #ownership_ratio_group').removeClass('d-none');
        } else {
            $('#partners_amount_group, #ownership_ratio_group').addClass('d-none');
        }

    }
</script>
