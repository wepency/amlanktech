<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-4">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">المالك</th>
                <th scope="col">الوقت</th>
            </tr>
            </thead>
            <tbody>

            @foreach($reactions as $reaction)
                <tr>
                    <th scope="row">{{$reaction?->user?->name}}</th>
                    <td>{{$reaction->created_at}}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>
