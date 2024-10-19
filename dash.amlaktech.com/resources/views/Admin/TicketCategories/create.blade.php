<form method="post" action="{{$url}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($model->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name" class="required">التصنيف </label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{old('name') ?? $model->name}}" required/>
            </div>

            @if(is_admin())
                <div class="form-group" id="association-all">
                    <label for="association_id" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', ['currentValue' => $model->association_id])
                </div>
            @endif

            <div class="form-group">
                <label for="name" class="required"> مهلة التصعيد </label>
                {{--                <p><small class="text-muted">عدد الساعات المسموح بها قبل ظهور زر تصعيد الطلب</small></p>--}}

                <div class="form-inline">
                    @php
                        $type = $model->appeal_period_type == 'days' || $model->appeal_period > 24 ? 'days' : 'hours';
                        $amount = $model->appeal_period > 24 ? $model->appeal_period / 24 : $model->appeal_period;
                    @endphp

                    <input type="text" class="form-control" id="appeal_period" name="appeal_period"
                           value="{{old('appeal_period') ?? $amount ?? 2}}"/> &nbsp;

                    <select name="appeal_period_type" id="appeal_period_type" class="form-control">
                        <option value="hours" {{$type == 'hours' ? 'selected' : ''}}>ساعه / ساعات
                        </option>
                        <option value="days" {{$type == 'days' ? 'selected' : ''}}>يوم/آيام</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
