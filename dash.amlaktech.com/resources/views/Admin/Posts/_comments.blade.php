<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$page_title}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-4">
        @foreach($comments as $comment)
            <div class="mt-2">
                <h5>{{$comment?->user?->name ?? 'مالك غير معروف'}}</h5>
                <p style="font-weight: 600">{{$comment->content}}</p>
            </div>

            <hr />
        @endforeach

    </div>
</div>
