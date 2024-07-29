<form action="{{dashboard_route('tickets.update', $ticket->id)}}" method="post" enctype="multipart/form-data">
    @csrf

    @method('PUT')

    <div class="form-group required">
        <label for="title">موضوع التذكرة</label>
        <input type="text" class="form-control" id="title" name="title" value="{{$ticket->title}}" readonly />
    </div>

    <div class="form-group required">
        <label for="body">الرد</label>
        <textarea class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" id="body" name="body" required>{{old('body')}}</textarea>

        @if($errors->has('body'))
            <p class="text-danger">{{$errors->first('body') ?? $ticket->body}}</p>
        @endif
    </div>

    <div class="form-group">
        <label for="attachment">المرفقات</label>
        <input class="d-block {{$errors->has('title') ? 'is-invalid' : ''}}" type="file" accept="application/pdf, image/*" id="attachment" name="attachment" />

        @if($errors->has('attachment'))
            <p class="text-danger">{{$errors->first('attachment')}}</p>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save"></i>
        <span class="text">الارسال</span>
    </button>
</form>
