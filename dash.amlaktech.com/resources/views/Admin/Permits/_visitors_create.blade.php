<?php
    $index = time().'-'.rand(10000, 99999);
?>
<div class="visitor">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="visitor-name">اسم الزائر</label>
                <input type="text" id="visitor-name" name="visitors[{{$index}}][visitor_name]" class="form-control" value="{{$visitor->visitor_name ?? ''}}" />
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label for="national-id">رقم الهوية</label>
                <input type="number" id="national-id" name="visitors[{{$index}}][national_id]" min="0" step="1" class="form-control" value="{{$visitor->national_id ?? ''}}" oninput="limitDigits(this)" />
            </div>
        </div>

        <div class="col-md-4 col-sm-12 d-flex justify-content-end align-items-center">
            <div class="buttons d-flex">
                <button type="button" class="btn btn-success me-2 btn-sm add-visitor"><i class="fa fa-plus-circle"></i></button>
                <button type="button" class="btn btn-danger btn-sm delete-visitor"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
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
