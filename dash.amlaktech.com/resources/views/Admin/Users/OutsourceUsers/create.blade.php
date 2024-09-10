<form method="post" action="{{$url}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($user->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">الاسم <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="add-name" name="name"
                       value="{{old('name') ?? $user->name}}" required/>
            </div>

            <div class="form-group">
                <label for="phonenumber"> رقم الجوال </label>
                <input type="number" class="form-control" id="phonenumber" name="phone_number"
                       value="{{old('phone_number') ?? $user->phone_number}}" />
            </div>

            <div class="form-group">
                <label for="email"> البريد الإلكتروني </label>

                <input type="email" class="form-control" id="email" name="email"
                       value="{{old('email')  ?? $user->email }}" />
            </div>

            @if(!is_admin())
                <div class="form-group">
                    <label for="association_id">الجمعية</label>

                    <select name="association_id" id="association_id" class="form-control">
                        <option value="">اختر الجمعية</option>

                        @foreach($associations as $association)
                            <option value="{{$association->id}}" {{$user->association_id == $association->id ? 'selected' : ''}}>{{$association->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="form-group">
                <label for="association_id">الشركة الخدمية</label>

                <select name="company_id" id="company_id" class="form-control">
                    <option value="">اختر الشركة</option>

                    @foreach($companies as $company)
                        <option value="{{$company->id}}" {{$user->association_id == $company->id ? 'selected' : ''}}>{{$company->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="profession">المهنة</label>
                <input type="text" class="form-control" id="profession" name="profession"
                       value="{{old('profession') ?? $user->profession}}" required/>
            </div>

            <div class="form-group">
                <label for="salary">الراتب</label>
                <input type="text" class="form-control" id="salary" name="salary"
                       value="{{old('salary') ?? $user->salary}}" required/>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
