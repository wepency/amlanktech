<div class="form-group">
    <label for="name" class="required">الاسم </label>
    <input type="text" class="form-control" id="name" name="name"
           value="{{old('name') ?? $member->name}}" required/>
</div>

<div class="form-group">
    <label for="phonenumber" class="required"> رقم الجوال </label>
    <input type="number" id="phonenumber" name="phone_number" min="0" step="1" class="form-control" value="{{old('phone_number') ?? $member->phone_number}}" oninput="limitDigits(this)" required />
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

<script>
    function limitDigits(input) {
        const maxLength = 10;
        const value = input.value;
        if (value.length > maxLength) {
            input.value = value.slice(0, maxLength);
        }
    }
</script>
