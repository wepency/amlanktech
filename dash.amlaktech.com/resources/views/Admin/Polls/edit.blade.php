<form method="post" action="{{route('dashboard.polls.update',['poll'=>$poll->id])}}" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            @csrf

            @include('messages')
            @method('PUT')
            
            <div class="form-group">
                <label for="add-name">اسم التصويت <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" id="name" name="name" value="{{old('name') ?? $poll->name}}" required>
            </div>

            <div class="form-group">
                <label for="options" class="form-label">اضف الاختيارات</label>
                @foreach($poll->options as $option)
                    <input type="text" class="form-control" name="options[]" placeholder="Options" value="{{$option->option}}">
                @endforeach
            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> تعديل التصويت  </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>
</form>
