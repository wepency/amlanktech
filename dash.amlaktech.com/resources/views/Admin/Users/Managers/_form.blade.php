@php
    $managerName = isset($type) ? 'manager_name' : 'name';
@endphp

<div class="form-group">
    <label for="{{$managerName}}" class="required"> الاسم </label>
    <input type="text" class="form-control" id="{{$managerName}}" name="{{$managerName}}" value="{{old("{$managerName}") ?? $manager->{$managerName} }}" required/>
</div>

<div class="form-group">
    <label for="phonenumber" class="required"> رقم الجوال </label>
    <input type="number" class="form-control" id="phonenumber" name="phone_number"
           value="{{old('phone_number') ?? $manager->phone_number}}" required />
</div>

<div class="form-group">
    <label for="national_id" class="required"> رقم الهوية </label>
    <input type="text" class="form-control" id="national_id" name="national_id"
           value="{{old('national_id') ?? $manager->national_id}}" required />
</div>

<div class="form-group">
    <label for="email" class="required"> البريد الالكتروني </label>
    <input type="email" class="form-control" id="email" name="email" value="{{old('email')  ?? $manager->email }}"/>
</div>

@if(!isset($type) && !empty($associations) && is_admin())
    <div class="form-group">
        <label for="association_id"> الجمعية </label>

        <select class="form-control select2" id="association_id" name="association_id">
            @foreach($associations as $association)
                <option value="{{$association->id}}" {{$association->id == $manager->association_id ? 'selected' : ''}}>{{$association->name}}</option>
            @endforeach
        </select>
    </div>
@endif

<div class="form-group">
    <label for="password" class="{{$manager->exists ?: 'required'}}"> كلمة المرور </label>
    <input type="password" class="form-control" id="password" name="password" {{$manager->exists ?: 'required'}} />
</div>

<div class="form-group">
    <label for="password-confirmation" class="{{$manager->exists ?: 'required'}}"> تأكيد كلمة المرور </label>
    <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" {{$manager->exists ?: 'required'}} />
</div>

@if(!empty($roles))
    <div class="form-group">
        <label for="role-group" class="required"> الصلاحية </label>

        <select name="role_group" id="role-group" class="form-control">
            <option value=""></option>

            @foreach($roles as $role)
                <option value="{{$role->name}}" {{in_array($role->name, $manager->roles->pluck('name')->toArray()) ? 'selected' : ''}}>{{$role->main_name}}</option>
            @endforeach
        </select>
    </div>
@else
    <input type="hidden" name="hide_admin" value="1" />
    <input type="hidden" name="role_group" value="7" />
@endif
