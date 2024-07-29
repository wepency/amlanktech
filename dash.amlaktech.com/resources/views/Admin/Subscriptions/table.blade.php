<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$page_title}}</h3>
        </div>

        <div class="card-body pt-10">
            <div class="text-right mb-3">
                <a href="{{route('dashboard.subscriptions.index' )}}" class="btn btn-info mb-1">
                    <i class="fa fa-list"></i> &nbsp;
                    <span>الكل</span>
                </a>

                <a href="{{route('dashboard.subscriptions.paid')}}" class="btn btn-success mb-1">
                    <i class="fa fa-check"></i> &nbsp;
                    <span>المدفوعات</span>
                </a>

                <a href="{{route('dashboard.subscriptions.notPaid')}}" class="btn btn-warning mb-1">
                    <i class="fa fa-times"></i> &nbsp;
                    <span> المستحقات </span>
                </a>
                <a href="{{route('dashboard.subscriptions.late')}}" class="btn btn-danger mb-1">
                    <i class="fas fa-clock"></i> &nbsp;
                    <span >المتأخرات </span>
                </a>
            </div>

            <div class="table-responsive">

                    <table id="data-table" class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                        <thead>

                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">الجمعية</th>
                            <th scope="col">الوحدة</th>
                            <th scope="col">نوع الاشتراك</th>
                            <th scope="col">مبلغ الاشتراك</th>
                            <th scope="col">الإجمالي</th>
                            <th scope="col">تاريخ بداية الدفع</th>
                            <th scope="col">تاريخ نهاية الدفع</th>
                            <th scope="col">تم الدفع</th>

                            <th scope="col">حالة الإشتراك</th>
                            <th scope="col">إجراءات</th>
                        </tr>

                        </thead>
                        <tbody class="row_position">

                            @foreach($subscriptions as $subscription)
                                <tr id="{{$subscription?->id}}">
                                    <td>{{pad_code($subscription?->id)}}</td>
                                    <td>{{$subscription?->association?->name}}</td>
                                    <td>{{$subscription?->unit?->unit_no}}</td>
                                    <td>{{$subscription?->subscriptionType->name_en}}</td>

                                    <td>{{$subscription?->amount}}</td>
                                    <td>{{$subscription?->total}}</td>
                                    <td>{{$subscription?->start_payment}}</td>
                                    <td>{{$subscription?->end_payment}}</td>

                                        @if($subscription?->is_paid ===0)
                                            <td>
                                                <div  class="bg-danger p-2 text-center rounded">
                                                    <i class="fa fa-times"></i>
                                                </div>
                                            </td>
                                        @else
                                            <td>
                                                <div  class="bg-success p-2 text-center rounded">
                                                    <i class="fa fa-check"></i>
                                                 </div>

                                            </td>
                                        @endif

                                    <td><i class="fa fa-check"></i> تم الاشتراك </td>

                                    <td>

                                        <!-- Edit -->
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip" title="تعديل" data-bs-toggle="modal" data-bs-target="#edit-subscription-{{$subscription->id}}"><i class="far fa-edit"></i></button>

                                        <!-- Delete -->
                                        <form method="post" action="{{route('dashboard.subscriptions.destroy', [ 'subscription' => $subscription->id])}}" style="display:inline-block;margin:0">
                                            @csrf
                                            @method('delete')

                                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="الحذف"><i class="fas fa-trash"></i></button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                        {{ $subscriptions->links() }}

            </div>

        </div>

    </div>
</div>
