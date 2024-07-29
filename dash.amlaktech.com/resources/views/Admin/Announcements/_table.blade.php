<div class="table-responsive">
    <table id="data-table" class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
        <thead>

        <tr>
            <th scope="col">#</th>

            <th scope="col">عنوان الاعلان</th>

            <th scope="col">محتوى الاعلان</th>

            <th scope="col">إجراءات</th>
        </tr>

        </thead>

        <tbody>

        @foreach($announcements as $announcement)
            <tr id="{{$announcement->id}}">
                <td>{{pad_code($announcement->id)}}</td>

                <td>{{$announcement->title}}</td>
                <td>{!! substr($announcement->body, 0, 150) !!}</td>

                <td>
                    <!-- Edit -->
                    {{-- @if (can('edit bill')) --}}

                    <button type="button" class="btn btn-primary  edit-announcement-btn"
                            data-toggle="tooltip" title="تعديل" data-bs-toggle="modal"
                            data-bs-target="#add-edit-announcements">
                        <i class="far fa-edit"></i>
                    </button>


                    <!-- Delete -->

                    {{-- @if (can('delete bill')) --}}
                    <form method="post" action="{{route('dashboard.announcements.destroy', [ 'announcement' => $announcement->id])}}" style="display:inline-block;margin:0">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-danger delete" data-toggle="tooltip" title="الحذف"><i class="fas fa-trash"></i></button>
                    </form>
                    {{-- @endif --}}



                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
