<form method="post" action="{{$url}}" id="task-form" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($task->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title" class="required">اسم المهمة</label>

                <input type="text" class="form-control" id="title" name="title"
                       value="{{old('title') ?? $task->title}}" required />
            </div>

            <div class="form-group">
                <label for="description">وصف المهمة</label>
                <textarea id="description" class="form-control" name="description">{!! old('description') ?? $task->description !!}</textarea>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>

                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $task->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label for="assign_to">اسناد المهمة الى</label>

                <select name="assigned_to" id="assigned_to" class="form-control select2">

                    @foreach($associationMembers as $member)
                        <option value="{{ $member->id }}" {{$member->id == $task->assigned_to ? 'selected' : ''}}>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="start-date" class="required">تاريخ البداية</label>
                <input type="date" class="form-control" id="start-date" name="start_date"
                       value="{{old('start_date') ?? $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') : null}}" required/>
            </div>

            <div class="form-group">
                <label for="target-date" class="required">التاريخ المستهدف</label>
                <input type="date" class="form-control" id="target-date" name="target_date"
                       value="{{old('target_date') ?? $task->target_date ? \Carbon\Carbon::parse($task->target_date)->format('Y-m-d') : null}}" required/>
            </div>

            <div class="form-group">
                <label for="end-date">تاريخ النهاية</label>
                <input type="date" class="form-control" id="end-date" name="end_date"
                       value="{{old('end_date') ?? $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') : ''}}" />
            </div>

            <div class="form-group">
                <label for="finished">تم انجازها؟</label>

                <div>
                    <label class="switch">
                        <input type="checkbox" id="finished" name="finished" {{$task->finished ? 'checked' : ''}} />
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
        $('#assigned_to').select2({
            dropdownParent: $('.modal-body')
        });
    })
</script>
