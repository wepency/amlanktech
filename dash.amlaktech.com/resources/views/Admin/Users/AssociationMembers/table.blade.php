<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$page_title}}</h3>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="association">أعضاء الجمعية</label>

                    <select class="select2 form-control" name="association" id="association">
                        <option value="">الكل</option>

                        @foreach($associations as $association)
                            <option value="{{$association->id}}">{{$association->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table id="data-table"
                       class="border-top-0 table text-left table-hover text-nowrap key-buttons data-table">
                    <thead>

                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">الاسم</th>
                        <th scope="col">رقم الجوال</th>

                        @if(is_admin())
                            <th scope="col">الجمعيات</th>
                        @endif

                        <th scope="col">عدد الوحدات</th>

{{--                        <th scope="col">نوع الملكية</th>--}}
{{--                        <th scope="col">عدد الشركاء</th>--}}
{{--                        <th scope="col">نسبة الملكية</th>--}}
{{--                        <th scope="col">قيمة الاشتراك</th>--}}
{{--                        <th scope="col">العنوان</th>--}}
{{--                        <th scope="col">رقم عداد المياه</th>--}}
{{--                        <th scope="col">رقم عداد الكهرباء</th>--}}
                        <th scope="col">حالة حساب المالك</th>
                        <th scope="col">إجراءات</th>
                    </tr>

                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
