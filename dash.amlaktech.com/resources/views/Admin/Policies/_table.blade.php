<div class="table-responsive">

    <table id="data-table"
           class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
        <thead>

        <tr>
            <th scope="col">#</th>
            <th scope="col">الاسم</th>

            @if(is_admin())
                <th scope="col">الجمعية</th>
            @endif

            <th scope="col">حالة اللائحة</th>

            <th scope="col">إجراءات</th>
        </tr>

        </thead>
        <tbody class="row_position">

        @foreach($policies as $policy)
            <tr id="{{$policy->id}}">
                <td>{{pad_code($policy->id)}}</td>
                <td>{{$policy->name}}</td>

                @if(is_admin())
                    <td>{{$policy->association->name}}</td>
                @endif

                <td>{!! get_badge($policy->status) !!}</td>

                <td>
                    <!-- Edit -->

                    <button type="button" class="btn btn-primary  edit-policy-btn"
                            data-toggle="tooltip" title="تعديل" data-bs-toggle="modal"
                            data-bs-target="#add-edit-policies">
                        <i class="far fa-edit"></i>
                    </button>

                    <a href="{{ route('dashboard.policies.download_policy_file' , [ 'policy' => $policy->id]) }}">
                        <button class="btn btn-secondary" title=" تحميل اللائحة ">
                            <i class="fas fa-download"></i>
                        </button>
                    </a>
                    <!-- Delete -->

                    <form method="post"
                          action="{{route('dashboard.policies.destroy', [ 'policy' => $policy->id])}}"
                          style="display:inline-block;margin:0">
                        @csrf
                        @method('delete')

                        <button type="submit"
                                class="btn btn-danger delete" data-toggle="tooltip" title="الحذف"><i
                                class="fas fa-trash"></i></button>

                    </form>

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>
