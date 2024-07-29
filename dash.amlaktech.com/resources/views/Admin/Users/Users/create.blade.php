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
                <label for="name" class="required">الاسم </label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{old('name') ?? $user->name}}" required/>
            </div>

            <div class="form-group">
                <label for="phonenumber" class="required">رقم الجوال</label>
                <input type="number" class="form-control" id="phonenumber" name="phone_number"
                       value="{{old('phone_number') ?? $user->phone_number}}" required/>
            </div>

            <div class="form-group">
                <label for="address" class="required">العنوان</label>
                <input type="text" class="form-control" id="address" name="address"
                       value="{{old('address') ?? $user->address}}" required/>
            </div>

            @if(is_admin())
                <div class="form-group" id="association-all">
                    <label for="association_id" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', ['currentValue' => $user->association_id])
                </div>
            @endif

            <div class="form-group">
                <label for="profession" class="required">المهنة</label>
                <input type="text" class="form-control" id="profession" name="profession"
                       value="{{old('profession') ?? $user->profession}}" required/>
            </div>

            <div class="form-group">
                <label for="salary" class="required">الراتب</label>
                <input type="text" class="form-control" id="salary" name="salary"
                       value="{{old('salary') ?? $user->salary}}" required/>
            </div>

            <div class="form-group">
                <label for="email" class="required"> البريد الإلكتروني </label>
                <input type="email" class="form-control" id="email" name="email"
                       value="{{old('email')  ?? $user->email }}" required />
            </div>

            <div class="form-group">
                <label for="password" class="{{$user->exists ?: 'required'}}"> كلمة المرور </label>
                <input type="password" class="form-control" id="password" name="password" {{$user->exists ?: 'required'}} />
            </div>

            <div class="form-group">
                <label for="password-confirmation" class="{{$user->exists ?: 'required'}}"> تأكيد كلمة المرور </label>
                <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" {{$user->exists ?: 'required'}} />
            </div>

            <div class="form-group">
                <label for="role-group" class="required"> الصلاحية </label>

                <select name="role_group" id="role-group" class="form-control">
                    <option value=""></option>

                    @foreach($roles as $role)
                        <option value="{{$role->name}}" {{in_array($role->name, $user->roles->pluck('name')->toArray()) ? 'selected' : ''}}>{{$role->main_name}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
