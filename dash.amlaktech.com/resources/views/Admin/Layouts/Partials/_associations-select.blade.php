@php
    if (!isset($associations)) {
        $associations = getAssociations();
    }

    if (!isset($currentValue)) {
        $currentValue = '';
    }

@endphp

<select name="association_id" id="{{$id ?? 'association_id'}}" class="form-control {{$id ?? 'associations'}} select2">
    <option></option>
    @foreach($associations as $association)
        <option value="{{ $association->id }}" {{$association->id == $currentValue ? 'selected' : ''}}>{{ $association->name }}</option>
    @endforeach
</select>

<script>
    $(document).ready(function () {
        $('.associations').select2({
            @if(!isset($id))
            dropdownParent: $('.modal-body')
            @endif
        });
    })
</script>
