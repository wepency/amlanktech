<div class="table-responsive">
    <table id="data-table" class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
        <thead>

        <tr>
            <th scope="col">#</th>
            <th scope="col"> موضوع الاجتماع</th>
            <th scope="col">الجمعية</th>
            <th scope="col">تاريخ الاجتماع</th>
            <th scope="col">موعد بدء الاجتماع</th>
            <th scope="col">موعد الانتهاء المتوقع</th>
            <th scope="col">إجراءات</th>
        </tr>

        </thead>
        <tbody class="row_position">

        @foreach($meetings as $meeting)
            <tr id="{{$meeting->id}}">
                <td>{{pad_code($meeting->id)}}</td>

                <td>{{$meeting->title}}</td>

                <td>{{$meeting?->association?->name}}</td>

                <td>{{$meeting->date}}</td>
                <td>{{$meeting->start_time}}</td>
                <td>{{$meeting->end_time ?? '--'}}</td>

                <td>

                    <div class="table-buttons">
                        <!-- Edit -->
                        {{-- @if (can('edit meeting')) --}}

                        <button type="button" class="btn btn-primary btn-icon edit-meeting-btn"
                                data-toggle="tooltip" title="تعديل" data-bs-toggle="modal"
                                data-bs-target="#add-edit-meetings">
                            <i class="far fa-edit"></i>
                        </button>

                        {{-- @endif --}}

                        {{-- @if (can('edit meeting')) --}}

                        <button type="button" class="btn btn-success btn-icon edit-agenda-btn"
                                data-toggle="tooltip" title="محاضر الاجتماع" data-bs-toggle="modal"
                                data-bs-target="#agenda-modal">
                            <i class="mdi mdi-file-pdf"></i>
                        </button>

                        {{-- @endif --}}

                        {{-- @if (can('edit meeting')) --}}

                        <button type="button" class="btn btn-secondary btn-icon edit-decisions-btn"
                                data-toggle="tooltip" title="قرارات الاجتماع" data-bs-toggle="modal"
                                data-bs-target="#decisions-modal">
                            <i class="mdi mdi-folder-move"></i>
                        </button>

                        {{-- @endif --}}

                        <button type="button" class="btn btn-warning btn-icon edit-decisions-btn"
                                data-toggle="tooltip" title="سجل حضور الاجتماع" data-bs-toggle="modal"
                                data-bs-target="#user-logs-modal">
                            <i class="fa fa-users"></i>
                        </button>

                        <!-- Delete -->

                        {{-- @if (can('delete bill')) --}}
                        <form method="post" action="{{route('dashboard.meetings.destroy', [ 'meeting' => $meeting->id])}}" style="display:inline-block;margin:0">
                            @csrf
                            @method('delete')

                            <button type="submit" class="btn btn-danger btn-icon delete" data-toggle="tooltip" title="الحذف"><i class="fas fa-trash"></i></button>
                        </form>
                        {{-- @endif --}}
                    </div>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
