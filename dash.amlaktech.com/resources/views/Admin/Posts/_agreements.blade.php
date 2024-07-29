<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">اسم العضو</th>
                <th scope="col">تاريخ الموافقة</th>
            </tr>
            </thead>
            <tbody>
            @foreach($agreements as $agreement)

                <tr>
                    <th scope="row">{{$agreement->name}}</th>
                    <td>{{$agreement->pivot->created_at->format('Y-m-d H:i:s')}}</td>
                </tr>

            @endforeach
            </tbody>
        </table>


        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">إغلاق</button>
        </div>
    </div>

</div>
