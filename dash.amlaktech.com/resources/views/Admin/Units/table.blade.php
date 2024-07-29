<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$page_title}}</h3>
        </div>

        <div class="card-body">

            @if(!$units->count())
                <!-- Get Empty SVG if no data -->
                @include('Admin.Layouts.Partials._empty')
            @else

                @include('Frontend.Partials._messages')

                <div class="table-responsive">
                    <table id="data-table"
                           class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
                        <thead>

                        <tr>

                            <th scope="col">رقم الوحدة</th>
                            <th scope="col">مالك الوحدة</th>
                            <th scope="col">الجمعية</th>

                            <th scope="col"> نوع الملكية</th>
                            <th scope="col"> عدد الشركاء</th>
                            <th scope="col"> نسبة الملكية</th>

                            <th scope="col">دورة الاشتراك</th>
                            <th scope="col">قيمة الاشتراك</th>

                            <th scope="col"> العنوان</th>
                            <th scope="col">رقم عداد المياه</th>
                            <th scope="col">رقم عداد الكهرباء</th>
                            <th scope="col"> ملاحظات</th>
                            <th scope="col">إجراءات</th>

                        </tr>

                        </thead>

                        <tbody>

                        @foreach($units as $unit)
                            @php
                                $subPeriod = $unit?->association?->subscription_period;
                            @endphp

                            <tr id="{{$unit->id}}">

                                <td>#{{$unit->id}}</td>

                                <td>
                                    <a href="{{dashboard_route('units.index', ['member_id' => $unit->association_member_id])}}"
                                       class="mb-0"><i class="fa fa-check-circle text-success"></i>
                                        <strong> {{($unit?->associationMember?->name ?? 'غير معروف') }} </strong></a>
                                </td>

                                <td>
                                    <a href="{{dashboard_route('units.index', ['association_id' => $unit->association_id])}}"
                                       class="mb-0 text-black">{{($unit?->association?->name ?? 'غير معروفة') }}</a>
                                </td>

                                <td>
                                    <p class="text-danger">
                                        @if($unit->ownership_type == 'group')
                                            <i class="fa fa-users"></i>
                                        @else
                                            <i class="fa fa-user"></i>
                                        @endif

                                        {{__('labels.ownership.'.$unit->ownership_type)}}
                                    </p>
                                </td>

                                <td>
                                    {{$unit->partners_amount ?? 'لا يوجد شركاء'}}
                                </td>

                                <td>
                                    {{$unit->ownership_ratio ?? 100}}%
                                </td>


                                <td>{{subPeriodText($subPeriod)}}</td>
                                <td>{{currency($unit->fee_type_total * $subPeriod)}}

                                <td>{{$unit->address}}</td>

                                <td>{{$unit->water_meter_serial}}</td>
                                <td>{{$unit->electricity_meter_serial}}</td>

                                <td>{{$unit->notes ?? '--'}}</td>

                                <td>

                                    <!-- Edit -->
                                    <button type="button" class="btn btn-primary edit-unit-btn" data-toggle="tooltip"
                                            title="تعديل" data-bs-toggle="modal" data-bs-target="#add-edit-unit"><i
                                                class="far fa-edit"></i></button>

                                    <!-- Delete -->
                                    <form method="post"
                                          action="{{route('dashboard.units.destroy', [ 'unit' => $unit->id])}}"
                                          style="display:inline-block;margin:0">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-danger delete" data-toggle="tooltip"
                                                title="الحذف"><i class="fas fa-trash"></i></button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>

            @endif

        </div>
        {{ $units->links() }}

    </div>
</div>
