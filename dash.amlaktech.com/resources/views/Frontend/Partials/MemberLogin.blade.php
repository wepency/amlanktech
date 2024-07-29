<div class="tab-pane login-tab fade show active" id="login-tab" role="tabpanel">
    <h3 class="item-title">تسجيل الدخول</h3>

    <form action="{{url('/login')}}" method="POST">
        @csrf

        <div class="form-group has-error">
            <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{old('email')}}" placeholder="رقم الجوال او البريد الالكتروني" required />
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required />
        </div>

{{--        <div class="form-group reset-password">--}}
{{--            <a href="#">استعادة كلمة المرور</a>--}}
{{--        </div>--}}

        <div class="form-group mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="validationFormCheck2">
                <label class="form-check-label" for="validationFormCheck2">تذكر دخولي؟</label>
            </div>
        </div>

        <div class="form-group">
            <button class="submit-btn" name="login-btn" type="submit">تسجيل الدخول</button>
        </div>
    </form>
    <!-- <div class="account-create">
Don't have an account yet? <a href="#registration-tab">Sign Up Now</a>
</div> -->
</div>
