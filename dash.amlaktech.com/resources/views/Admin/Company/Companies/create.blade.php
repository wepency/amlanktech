<form method="post" action="{{$url}}" id="bill-id-form" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($company->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name" class="required">اسم الشركة</label>

                <input type="text" class="form-control" id="name" name="name"
                       value="{{old('name') ?? $company->name}}" required/>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>

                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $company->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="amount" class="required">مبلغ التعاقد</label>
                <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount') ?? $company->amount}}" required/>
            </div>

            <div class="form-group required">
                <label for="file_path">العقد</label>

                <input type="file" class="form-control" id="file_path" name="file_path" />

                @if($company->exists)
                    <a href="{{asset('uploads/'.$company->file_path)}}" target="_blank">عرض العقد</a>
                @endif
            </div>

            <div class="form-group">
                <label for="added_to_budget">مضافة للميزانية أم لا</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="added_to_budget" name="added_to_budget" {{$company->added_to_budget ? 'checked' : ''}} />
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


<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>
