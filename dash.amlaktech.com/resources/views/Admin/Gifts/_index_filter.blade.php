<div class="row">
    @if(!is_manager())
        <div class="col-md-3">
            <div class="form-group">
                <label for="association">الجمعية</label>

                <select class="form-control select2" id="association">
                    <option></option>

                    @foreach($associations as $association)
                        <option value="{{$association->id}}">{{$association->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <div class="col-md-3">
        <div class="form-group">
            <label for="association-member">عضو الجمعية</label>

            <select class="form-control select2" id="association-member">
                <option></option>
            </select>
        </div>
    </div>
</div>
