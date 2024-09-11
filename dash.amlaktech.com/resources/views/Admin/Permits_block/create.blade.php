<form method="post" action="{{$url}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            <!-- Members -->
            <div class="form-group">
                <label for="member_id" class="required">رقم الهوية</label>
                <input type="number" id="national-id" name="national_id" min="0" step="1" class="form-control" oninput="limitDigits(this)" />
            </div>

            <!-- Associations -->
            @if(is_admin())
                <div class="form-group">
                    <label for="associations-select" class="required">الجمعية</label>
                    @include('Admin.Layouts.Partials._associations-select', [
                        'id' => 'associations-select',
                        'currentValue' => null
                    ])
                </div>
            @endif

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#associations-select').select2();
    })

    function limitDigits(input) {
        const maxLength = 10;
        const value = input.value;
        if (value.length > maxLength) {
            input.value = value.slice(0, maxLength);
        }
    }
</script>
