<div class="form-group">
    <label for="name" class="required">الاسم </label>
    <input type="text" class="form-control" id="name" name="name"
           value="{{old('name') ?? $member->name}}" required/>
</div>

<div class="form-group">
    <label for="phonenumber" class="required"> رقم الجوال </label>
    <input type="number" class="form-control" id="phonenumber" name="phone_number"
           value="{{old('phone_number') ?? $member->phone_number}}" required/>
</div>

<div class="form-group">
    <label for="email" class="required"> البريد الإلكتروني </label>
    <input type="email" class="form-control" id="email" name="email"
           value="{{old('email') ?? $member->email}}" required/>
</div>

<div class="form-group">
    <label for="password" class="{{$member->exists ?: 'required'}}"> كلمة المرور </label>
    <input type="password" class="form-control" id="password" name="password" {{$member->exists ?: 'required'}} />
</div>

<div class="form-group">
    <label for="password-confirmation" class="{{$member->exists ?: 'required'}}"> تأكيد كلمة المرور </label>
    <input type="password" class="form-control" id="password-confirmation" name="password_confirmation" {{$member->exists ?: 'required'}} />
</div>
