<div class="form-group">
    <label for="fee_type_amount"> {{$association->feeType->type}} <span class="text-danger">*</span> </label>
    <input type="number" class="form-control" id="fee_type_amount" name="fee_type_amount"
           value="{{old('fee_type_amount') ?? request()->amount}}" required />
</div>
