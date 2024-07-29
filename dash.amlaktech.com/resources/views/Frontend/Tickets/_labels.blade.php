<div class="card">

    <div class="card-header bg-primary text-white">الدعم الفني</div>

    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item">
                <i class="fa fa-envelope mr-2"></i>
                <a href="{{url('tickets?status=solved')}}">تذاكر جديدة</a>

                <span class="badge badge-danger">{{$tickets_count['not_solved']}}</span>
            </li>

            <li class="list-group-item">
                <i class="fa fa-spinner mr-2"></i>
                <a href="{{url('tickets?status=in_progress')}}">جاري الرد</a>

                <span class="badge badge-warning">{{$tickets_count['in_progress']}}</span>
            </li>

            <li class="list-group-item">
                <i class="fa fa-check mr-2"></i>
                <a href="{{url('tickets?status=solved')}}">تم الحل</a>

                <span class="badge badge-success">{{$tickets_count['solved']}}</span>
            </li>
        </ul>
    </div>
</div>
