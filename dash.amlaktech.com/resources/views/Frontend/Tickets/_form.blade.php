<form action="{{$ticket->exists ? url('tickets/'.$ticket->id) : url('tickets')}}" method="post" enctype="multipart/form-data">
    @csrf

    @if($ticket->exists)
        @method('PUT')
    @endif

    <div class="form-group required">
        <label for="title">موضوع التذكرة</label>
        <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="title" name="title" value="{{old('title') ?? $ticket->title}}" required />

        @if($errors->has('title'))
            <p class="text-danger">{{$errors->first('title')}}</p>
        @endif
    </div>

    <div class="form-group required">
        <label for="association_id">الجمعية</label>

        <select class="form-control select2 {{$errors->has('title') ? 'is-invalid' : ''}}" name="association_id" id="association_id" required>
            @foreach($associations as $association)
                <option value="{{$association->id}}" {{old('association_id') == $association->id ? 'selected' : ($ticket->association_id == $association->id ? 'selected' : '')}}>{{$association->name}}</option>
            @endforeach
        </select>

        @if($errors->has('association_id'))
            <p class="text-danger">{{$errors->first('association_id')}}</p>
        @endif
    </div>

    <div class="form-group required">
        <label for="importance">الأهمية</label>

        <select class="form-control select2 {{$errors->has('title') ? 'is-invalid' : ''}}" name="importance" id="importance" required>
            <option value="1" {{old('importance') == 1 ? 'selected' : ($ticket->importance == 1 ? 'selected' : '')}}>عادية</option>
            <option value="2" {{old('importance') == 2 ? 'selected' : ($ticket->importance == 2 ? 'selected' : '')}}>متوسطة</option>
            <option value="3" {{old('importance') == 3 ? 'selected' : ($ticket->importance == 3 ? 'selected' : '')}}>عاجلة</option>
        </select>

        @if($errors->has('importance'))
            <p class="text-danger">{{$errors->first('importance')}}</p>
        @endif
    </div>

    <div class="form-group required">
        <label for="body">محتوى التذكرة</label>
        <textarea class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" id="body" name="body" required>{{old('body')}}</textarea>

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
        <span class="text">{{$ticket->exists ? 'حفظ التذكرة' : 'فتح التذكرة'}}</span>
    </button>
</form>
