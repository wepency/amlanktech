@extends('Admin.Layouts.Dashboard')

@section('content')

    <!-- Add / Edit Member -->
    <div class="modal fade" id="add-edit-members" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog"></div>
    </div>

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{dashboard_route()}}">الرئيسية /</a></h4>
                <span class="text-muted mt-1 tx-13 ms-2 mb-0">{{$page_title}}</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">

            {{-- @if (can('add member')) --}}
            <button type="button" data-bs-toggle="modal" data-bs-target="#add-edit-members" id="add-member-btn"
                    class="btn btn-danger btn-icon mb-1 me-1"><i class="mdi mdi-plus"></i></button>
            {{-- @endif --}}

            <span class="btn btn-primary mb-1 me-1">
                <span>الملاك</span>
                <span class="badge bg-white ms-1"></span>
            </span>
        </div>
    </div>
    <!-- breadcrumb -->

    {{--    @include('Partners.Units.Statics')--}}

    <!-- Row -->
    <div class="row row-sm">
        @include('Admin.Users.AssociationMembers.table')
    </div>
    <!-- End Row -->

    <!-- Row -->
{{--    <div class="row row-sm">--}}
{{--        <div class="col-lg-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">{{$page_title}}</h3>--}}
{{--                </div>--}}

{{--                <div class="card-body">--}}

{{--                    <div class="table-responsive">--}}
{{--                        <table id="data-table"--}}
{{--                               class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">--}}
{{--                            <thead>--}}

{{--                            <tr>--}}
{{--                                <th scope="col">#</th>--}}
{{--                                <th scope="col">الاسم</th>--}}
{{--                                <th scope="col"> الجمعية</th>--}}
{{--                                <th scope="col"> قيمة الاشتراك السنوي </th>--}}
{{--                                <th scope="col"> رقم الجوال</th>--}}
{{--                                <th scope="col">إجراءات</th>--}}
{{--                            </tr>--}}

{{--                            </thead>--}}
{{--                            <tbody class="row_position">--}}

{{--                            @foreach($members as $member)--}}
{{--                                <tr id="{{$member->id}}">--}}
{{--                                    <td>{{pad_code($member->id)}}</td>--}}
{{--                                    <td>{{$member->name}}</td>--}}
{{--                                    <td>{{$member->association->name}}</td>--}}
{{--                                    <td>{{calculateFeesForMember($member->association->fee_amount, $member->fee_type_amount)}}</td>--}}
{{--                                    <td>{{$member->phone_number}}</td>--}}

{{--                                    <td>--}}

{{--                                        <!-- Edit -->--}}
{{--                                        --}}{{-- @if (can('edit member')) --}}
{{--                                        <button type="button" class="btn btn-primary edit-member-btn"--}}
{{--                                                data-toggle="tooltip" title="تعديل"--}}
{{--                                                data-bs-toggle="modal"--}}
{{--                                                data-bs-target="#add-edit-members">--}}
{{--                                            <i class="far fa-edit"></i>--}}
{{--                                        </button>--}}
{{--                                        --}}{{-- @endif --}}

{{--                                        <!-- Delete -->--}}
{{--                                        --}}{{-- @if (can('delete member')) --}}
{{--                                        <form method="post"--}}
{{--                                              action="{{route('dashboard.members.destroy', [ 'member' => $member->id])}}"--}}
{{--                                              style="display:inline-block;margin:0">--}}
{{--                                            @csrf--}}
{{--                                            @method('delete')--}}

{{--                                            <button type="submit" class="btn btn-danger" data-toggle="tooltip"--}}
{{--                                                    title="الحذف"><i class="fas fa-trash"></i></button>--}}
{{--                                        </form>--}}
{{--                                        --}}{{-- @endif --}}


{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}

{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <!-- End Row -->
@endsection

@push('scripts')
    <script>
        const AddMemberBtn = $('#add-member-btn');
        const EditMemberBtn = $('body').find('.edit-member-btn');
        const AddEditMemberModal = $('#add-edit-members');

        $('.select2').select2();

        AddMemberBtn.on('click', function (e) {
            e.preventDefault();
            AddEditMemberModal.find('.modal-dialog').html(getPreloader());

            $.get('{{dashboard_route('members.create')}}').done(function (data) {
                AddEditMemberModal.find('.modal-dialog').html(data.data);
                $('.select2').select2()
            });
        });

        $('body').on('click', '.edit-member-btn', function (e) {
            e.preventDefault();
            AddEditMemberModal.find('.modal-dialog').html(getPreloader());

            const id = $(this).parents('tr').attr('id')

            console.log(id)

            let url = '{{dashboard_route('members.edit', ':id')}}';
            url = url.replace(':id', id)

            $.get(url).done(function (data) {
                AddEditMemberModal.find('.modal-dialog').html(data.data);
                $('.select2').select2()
            });
        });

        $('body').on('click', '.accept', function (e){
            e.preventDefault();

            const form = $(this).parents('form');

            Swal.fire({
                title: "هل انت متأكد؟",
                text: "هل انت متأكد من قبول العضو؟",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "قبول",
                cancelButtonText: "الغاء",
                dangerMode: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            })

        });

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('dashboard.members.index') }}",
                data: function (d) {
                    d.association = $('#association').val(),
                    d.type = '{{request()->type}}'
                }
            },
            language: {
                searchPlaceholder: 'بحث ...',
                scrollX: "100%",
                sSearch: '',
                info: "عرض الصفحة _PAGE_ من _PAGES_",
                lengthMenu: '_MENU_ عقار/صفحة'
            },
            columns: [
                {data: 'id', name: 'id', orderable: true, searchable: false},
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'phone_number', name: 'phone_number', orderable: true, searchable: true},

                @if(is_admin())
                {data: 'association', name: 'association', orderable: true, searchable: true},
                @endif

                {data: 'units_count', name: 'units_count', orderable: true, searchable: false},
                {data: 'status', name: 'status', orderable: true, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true,
            order: [0, 'desc']
        });

        $('#association').on('change', function (){
            table.draw()
        })
    </script>
@endpush
