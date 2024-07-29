<form method="post" action="{{route('dashboard.polls.store')}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">اضافة تصويت جديد </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')

            <div class="form-group">
                <label for="add-name">اسم التصويت <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
            </div>

            <div class="form-group">
                <label for="options" class="form-label">اضف الاختيارات</label>
                <div id="options-container">
                    <input type="text" class="form-control" name="options[]" placeholder="Option">
                </div>

                <button type="button" id="add-options-btn" class="btn btn-primary"><i class="mdi mdi-plus"></i></button>
            </div>
            

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> اضافة تصويت  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>