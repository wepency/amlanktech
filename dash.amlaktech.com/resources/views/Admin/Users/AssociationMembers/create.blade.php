<form method="post" action="{{$url}}">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($member->exists)
                @method('PUT')
            @endif

            @include('Admin.Users.AssociationMembers._form')

            @if(is_admin())
                <h5><label for="association-id">الجمعيات</label></h5>

                <div class="form-group">
                    <select id="association-id" class="select2 form-control" name="association_id[]" multiple>
                        <option value=""></option>

                        @foreach($associations as $association)
                            <option value="{{$association->id}}" {{ in_array($association->id, $memberAssociations) ? 'selected' : '' }}>
                                {{$association->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

        </div>

        <div class="modal-footer">
            <button type="submit" id="association-submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>

<script>
{{--    @if($member->exists)--}}
{{--        getFeeTypeForm({{$member->association_id}}, {{$member->fee_type_amount}})--}}
{{--        checkIfDisabled()--}}
{{--    @endif--}}

    $('document').ready(function (){

        // $('#association-id').on('change', function (){
        //     const assoId = $(this).val();
        //     getFeeTypeForm(assoId);
        // })
        //
        // $('body').on('keyup', '#fee_type_amount', function (){
        //     checkIfDisabled()
        //
        //     console.log($('body').find('#fee_type_amount'))
        // })
    });

    // function getFeeTypeForm(assoId, feeTypeAmount = null){
    //     $.get('/api/dashboard/association/'+assoId+'/fee-type-form?amount='+feeTypeAmount).done(function (data){
    //         $('#association-form').html(data.data)
    //     }).fail(function (){
    //         $('#association-form').empty()
    //     })
    // }
    //
    //
    // function checkIfDisabled(){
    //     const FeeAmount = $('body').find('#fee_type_amount').val();
    //     const AssociationSubmit = $('#association-submit');
    //
    //     if(FeeAmount !== '') {
    //         AssociationSubmit.attr('disabled', false).removeClass('disabled')
    //     }else {
    //         AssociationSubmit.attr('disabled', true).addClass('disabled')
    //     }
    // }
</script>
