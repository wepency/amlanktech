<form method="post" action="{{$url}}" id="bill-id-form">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($meeting->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title" class="required">موضوع الاجتماع </label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{old('title') ?? $meeting->title}}" required/>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $meeting->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="date-picker" class="required">تاريخ الاجتماع</label>
                <input type="date" class="form-control" id="date-picker" name="date"
                       value="{{old('sate') ?? $meeting->date ? \Carbon\Carbon::parse($meeting->date)->format('Y-m-d') : null}}" required/>
            </div>

            <div class="form-group">
                <label for="date-picker" class="required">موعد بدء الاجتماع</label>
                <input type="time" class="form-control" id="date-picker" name="start_time"
                       value="{{old('start_time') ?? date('H:i', strtotime($meeting->start_time))}}" required/>
            </div>

            <div class="form-group">
                <label for="min-users">الحد الأدنى لبدء الاجتماع</label>
                <p class="text-muted">اتركه فارغا لبدء الاجتماع فورا.</p>

                <input type="number" min="1" class="form-control" id="min-users" name="min_users" value="{{old('min_users') ?? $meeting->min_users}}" />
            </div>

            <div class="form-group">
                <label for="min-users">هل الاجتماع؟</label>

                <div class="form-inline">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="users_type" id="managers" value="board_of_directors" {{$meeting->users_type == 'board_of_directors' ? 'checked' : ''}} />
                        <label class="form-check-label" for="managers">اجتماع مجلس ادارة</label>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="users_type" id="managers-users" value="association_members" {{$meeting->users_type == 'association_members' ? 'checked' : ''}} />
                        <label class="form-check-label" for="managers-users">اجتماع أعضاء المجلس</label>
                    </div>
                </div>
            </div>

            <hr />

            <h3>بيانات زووم</h3>
            <span class="text-muted">يمكنك تحصيل البيانات عند انشاء اجتماع جديد على زووم بنفس المسميات ادناه.</span>

            <hr />

            <div class="form-group required">
                <label for="meeting_id" class="required">meeting ID:</label>

                <input type="text" class="form-control" id="meeting_id" name="meeting_id" value="{{old('meeting_id') ?? $meeting->meeting_id}}" required />
            </div>

            <div class="form-group required">
                <label for="passcode" class="required">passcode:</label>
                <input type="text" class="form-control" id="passcode" name="passcode" value="{{old('passcode') ?? $meeting->passcode}}" required />
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function (){
        $('.select2').select2();
    })
</script>
