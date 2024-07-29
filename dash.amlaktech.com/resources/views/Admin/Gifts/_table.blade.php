<div class="table-responsive">

    <table id="data-table"
           class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
        <thead>

        <tr>
            <th scope="col">#</th>
            <th scope="col">المبلغ</th>
            <th scope="col">العضو</th>

            <th scope="col">الجمعية</th>

            <th scope="col">إجراءات</th>
        </tr>

        </thead>
        <tbody class="row_position">

        @foreach($gifts as $gift)
            <tr id="{{$gift->id}}">
                <td>{{pad_code($gift->id)}}</td>
                <td>{{$gift->amount}}</td>
                <td>{{$gift?->associationMember?->name}}</td>
                <td>{{$gift?->association?->name}}</td>

                <td>
                    <!-- Edit -->
                    {{-- @if (can('edit gift')) --}}
                    <button type="button" class="btn btn-primary" data-toggle="tooltip"
                            title="تعديل" data-bs-toggle="modal"
                            data-bs-target="#edit-gift-{{$gift->id}}"><i class="far fa-edit"></i>
                    </button>
                    {{-- @endif --}}

                    <!-- Delete -->
                    {{-- @if (can('delete gift')) --}}
                    <form method="post"
                          action="{{route('dashboard.gifts.destroy', [ 'gift' => $gift->id])}}"
                          style="display:inline-block;margin:0">
                        @csrf
                        @method('delete')

                        <button type="submit" class="btn btn-danger" data-toggle="tooltip"
                                title="الحذف"><i class="fas fa-trash"></i></button>
                    </form>
                    {{-- @endif --}}


                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
