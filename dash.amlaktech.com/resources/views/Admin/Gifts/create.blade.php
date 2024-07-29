<form method="post" action="{{$url}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            <div class="form-group">
                <label class="m-0 required" for="amount">المبلغ </label>
                <p class="info m-0 mb-2"><small class="text-muted">إجمالي مبلغ الهبة</small></p>

                <div class="small-input-group">
                    <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount') ?? $gift->amount}}" required />
                    <label>ر.س</label>
                </div>
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => $gift->association_id
                    ])
                </div>
            @endif

            <div class="form-group">
                <label class="m-0" for="association-member-id">العضو </label>
                <p class="info m-0 mb-2"><small class="text-muted">العضو المسند إليه الهبة</small></p>

                <select class="select2 form-control" id="association-member-id" name="association_member_id">
                    @foreach($members as $member)
                        <option value="{{$member->id}}" {{$member->id == $gift->association_member_id ? 'selected' : ''}}>{{$member->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="m-0 required" for="notes">ملاحظات </label>

                <div class="small-input-group">
                    <textarea class="form-control" id="notes" name="notes">{{old('notes') ?? $gift->notes}}</textarea>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });

</script>
