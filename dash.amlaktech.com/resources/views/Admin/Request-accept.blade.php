<form method="post" action="{{$url}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @method('PUT')

            @include('messages')

            <div class="form-group">
                <label class="m-0 required" for="amount"> تاريخ بداية الاشتراك </label>
                <p class="info m-0 mb-2"><small class="text-muted"> قم بتحديد تاريخ بداية الاشتراك حيث نقوم بدءا من هذا التاريخ احتساب الاشتراك. </small></p>

                <input id="valid-to" type="text" class="form-control valid_to" name="sub_start_date" value="{{old('valid_to') ?? \Carbon\Carbon::parse($unit->sub_start_date)->format('d-m-Y')}}" required />

            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> قبول الطلب  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
