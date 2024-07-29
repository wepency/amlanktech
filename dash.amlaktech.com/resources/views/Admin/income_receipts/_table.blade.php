<div class="table-responsive">
    <table id="data-table" class="border-top-0 table text-center table-hover text-nowrap key-buttons data-table">
        <thead>

        <tr>
            <th scope="col">#</th>
            <th scope="col">الغرض من السند</th>

            @if(is_admin())
                <th scope="col">الجمعية</th>
            @endif

            <th scope="col">التاريخ</th>

            <th scope="col">المبلغ</th>

            <th scope="col">الدفع عن طريق</th>

            <th scope="col">الحالة</th>

            <th scope="col">إجراءات</th>
        </tr>

        </thead>
        <tbody></tbody>
    </table>
</div>
