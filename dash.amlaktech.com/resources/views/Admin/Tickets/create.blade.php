<form method="post" action="{{$url}}" id="bill-id-form">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            @if($ticket->exists)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title">عنوان التزكرة <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="add-title" name="title"
                       value="{{old('title') ?? $ticket->title}}" required/>
            </div>

            <div class="form-group">
                <select class="form-select" id="status" name="status">
                        <option selected>Select Ticket Status</option>
                        <option value='inProgress'>inProgress</option>
                        <option value='solved'>solved</option>
                        <option value='notSolved'>notSolved</option>
                </select>
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
