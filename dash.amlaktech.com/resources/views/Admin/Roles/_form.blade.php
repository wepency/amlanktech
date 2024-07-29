<form action="{{$url}}" method="post" enctype="multipart/form-data">
    @csrf

    @if($role->exists)
        @method('PUT')
    @endif

    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="box box-body box-primary">
                <div class="">
                    <h3 class="box-title">الصلاحيات</h3>
                </div>

                @include('messages')

                <div class="form-group col-12">
                    <label for="role_name"> اسم مجموعة الصلاحيات </label>
                    <input type="text" id="role_name" class="form-control" name="role" style="width: 100%;"
                           value="{{$role->main_name}}" required/>
                </div>

                <div class="form-group col-12">
                    @foreach ($permissionGroups as $permissionGroupKey => $permissionGroup)

                        <h3 class="text-capitalize">{{trans('permissions.'.$permissionGroupKey)}}</h3>

                        @foreach ($permissionGroup as $permissionKey => $permission)

                            @php
                                $canSentence = "can $permission $permissionGroupKey";
                            @endphp
                            {{--                            @if(isset($term['name']) && isset($term['value']))--}}
                            <div class="form-inline mb-3">
                                <label for="{{$canSentence}}" class="checkbox">
                                    <input type="checkbox" id="{{$canSentence}}" name="permission[]"
                                           value="{{$canSentence}}" {{(!in_array($canSentence, $role->permissions->pluck('name')->toArray()) ?: 'checked')}} />
                                    <span class="mr-2"></span>

                                    {{trans('permissions.'.$canSentence)}}
                                </label>
                            </div>
                            {{--                            @endif--}}
                        @endforeach
                    @endforeach
                </div>

            </div>

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> حفظ الصلاحية </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> اغلاق </button>
        </div>
    </div>
</form>
