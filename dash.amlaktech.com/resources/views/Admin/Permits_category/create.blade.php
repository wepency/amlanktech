<form method="post" action="{{$url}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($permitCategory->exists)
                @method('PUT')
            @endif

            <!-- Category name -->
            <div class="form-group">
                <div class="form-group">
                    <label for="name" class="required">اسم التصنيف</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{$permitCategory->name ?? old('name')}}"/>
                </div>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $permitCategory->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="add-active">هل يتطلب موافقة؟</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="add-active"
                               name="need_approval" {{$permitCategory->need_approval == 1 ? 'checked' : ''}} />
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
