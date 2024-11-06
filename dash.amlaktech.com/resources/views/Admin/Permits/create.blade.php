<form method="post" action="{{$url}}" id="permit-form">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($permit->exists)
                @method('PUT')
            @endif

            <!-- Error Alert (Hidden initially) -->
            <div class="alert alert-danger alert-dismissible fade show" id="errorAlert" style="display: none;">
                <span id="errorMessage"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Members -->
            <div class="form-group">
                <label for="member_id" class="required">عضو الجمعية \ المالك</label>

                <select name="member_id" id="member_id" class="form-control select2 d-block w-100">
                    @foreach($members as $member)
                        <option
                            value="{{$member->id}}" {{$permit->member_id == $member->id ? 'selected' : ''}}>{{$member->name}}
                            - {{$member->phone_number}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Members -->
            <div class="form-group">
                <label for="member_id" class="required">تصنيف التصريح</label>

                <select name="member_id" id="member_id" class="form-control select2 d-block w-100">
                    @foreach($categories as $category)
                        <option
                            value="{{$category->id}}" {{$category->id == $permit->permit_category_id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $permit->association_id
                    ])
                </div>
            @endif

            <!-- Login Attempts -->
            <div class="form-group">
                <label for="login_attempts" class="required">عدد مرات الدخول</label>
                <input type="number" min="1" max="2" oninput="limitDigits(this, 2)" name="login_attempts"
                       class="form-control" id="login_attempts"
                       value="{{$permit->login_attempts ?? 1}}"/>
            </div>

            <!-- Start Date -->
            <div class="form-group">
                <div class="form-group">
                    <label for="start_date" class="required">تاريخ الدخول</label>
                    <input type="date"
                           @if(!$permit->exists)
                               min="{{now()->format('Y-m-d')}}"
                           @endif
                           name="start_date" class="form-control" id="start_date"
                           value="{{$permit->start_date ? $permit->start_date->format('Y-m-d') : ''}}" required/>
                </div>
            </div>

            <!-- Permit Days -->
            <div class="form-group">
                <div class="form-group">
                    <label for="permit_days" class="required">عدد أيام الدخول</label>
                    <input type="number" min="1" max="99" oninput="limitDigits(this, 2)" name="permit_days"
                           class="form-control" id="permit_days"
                           value="{{$permit->permit_days ?? 1}}"/>
                </div>
            </div>

            <!-- Type -->
            <div class="form-group">
                <!-- Permit Days -->
                <div class="form-group">
                    <div class="form-group">
                        <label for="type" class="required">نوع التصريح</label>

                        <select id="type" name="type" class="form-control select2">
                            <option value="maintenance" {{$permit->type == 'maintenance' ? 'selected' : ''}}>صيانة
                            </option>
                            <option value="worker" {{$permit->type == 'worker' ? 'selected' : ''}}>عامل</option>
                            <option value="deliver" {{$permit->type == 'deliver' ? 'selected' : ''}}>توصيل</option>
                            <option value="visitor" {{$permit->type == 'visitor' ? 'selected' : ''}}>زائر</option>
                        </select>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="add-active">تفعيل التصريح</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="add-active"
                               name="status" {{$permit->status == 1 ? 'checked' : ''}} />
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>

            <div id="visitors">
                @foreach($visitors as $visitor)
                    <!-- Visitors -->
                    @include('Admin.Permits._visitors_create', [
                        'visitor' => $visitor
                    ])
                @endforeach
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

        $('body').on('click', '.add-visitor', function (e) {
            e.preventDefault();
            const $this = $(this);

            $this.attr('disabled', true)

            $.get('{{dashboard_route('permits.visitors.row')}}').then(function (data) {
                $this.attr('disabled', false)
                $('#visitors').append(data.data);
            });
        })

        $('body').on('click', '.delete-visitor', function (e) {
            e.preventDefault();
            $(this).parents('.visitor').remove()
        });

        $('#associations-select').select2();
    })
</script>
