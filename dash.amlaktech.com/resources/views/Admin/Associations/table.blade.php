<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$page_title}}</h3>
        </div>

        <div class="card-body">

            @if(!$associations->count())
                <!-- Get Empty SVG if no data -->
                @include('Admin.Layouts.Partials._empty')
            @else
                <div class="table-responsive">
                    <table id="data-table"
                           class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                        <thead>

                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">اسم الجمعية</th>
                            <th scope="col">العنوان</th>
                            <th scope="col">رقم التسجيل</th>
                            <th scope="col"> المدير</th>

                            <th scope="col">بداية الاشتراك</th>
                            <th scope="col">نهاية الاشتراك</th>

                            <th scope="col"> نوع الاشتراك على الاعضاء</th>
                            <th scope="col"> الرسوم على الوحدة</th>

                            <th scope="col">الإجراءات</th>
                        </tr>

                        </thead>
                        <tbody class="">

                        @foreach($associations as $association)
                            <tr id="{{$association->id}}">
                                <td>{{pad_code($association->id)}}</td>
                                <td>{{$association->name}}</td>

                                <td>
                                    <p class="text-success">{{$association->address}}</p>

                                    @if($association->city)
                                        <p class="text-danger">{{$association?->city?->province?->name}} - {{$association?->city?->name}}</p>
                                    @endif
                                </td>

                                <td>{{$association->registration_number}}</td>

                                <td>
                                    <p class="text-success m-0">{{$association?->admin?->name ?? '--' }}</p>
                                    <p class="m-0"><strong>{{$association?->admin?->phone_number }}</strong></p>
                                </td>

                                <td>
                                    @if($association->subscription_start_date != '')
                                        {{$association->subscription_start_date}}
                                    @endif
                                </td>

                                <td>
                                    @if($association->subscription_start_date != '')
                                        {{\Carbon\Carbon::parse($association->subscription_start_date)->addYear()->format('Y-m-d')}}
                                    @endif
                                </td>

                                <td>
                                    {{$association?->feeType?->type}}
                                </td>

                                <td>{{currency($association?->fee_amount)}}</td>

                                <td>

                                    <!-- Edit -->
                                    <button type="button" class="btn btn-primary edit-association-btn" data-toggle="tooltip"
                                            title="تعديل" data-bs-toggle="modal" data-bs-target="#add-edit-associations"><i
                                            class="far fa-edit"></i></button>


                                    @if($association->registration_certificate)
                                        <a href="{{ route('dashboard.association.download_certificate' , [ 'association' => $association->id]) }}">
                                            <button class="btn btn-secondary" title="تحميل الشهادة">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </a>
                                    @endif

                                    {{-- <a href="{{ route('dashboard.association_address.show' , [ 'association' => $association->id]) }}">
                                        <button class="btn btn-success" title=" عرض العنوان">
                                            <i class="fas fa-address-book"></i>
                                        </button>
                                    </a> --}}

                                    <!-- Delete -->
                                    <form method="post"
                                          action="{{dashboard_route('associations.destroy', ['association' => $association->id])}}"
                                          style="display:inline-block;margin:0">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-danger delete" data-toggle="tooltip"
                                                title="الحذف"><i
                                                class="fas fa-trash"></i></button>
                                    </form>


                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            @endif

            {{ $associations->links() }}

        </div>
    </div>
</div>
