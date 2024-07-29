@if(!is_admin())
    @if(checkManagerSubscription())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="alert-inner--text">
                <p class="mb-0">برجاء تحديث الاشتراك ودفع قيمة الاشتراك السنوي.</p>
            </div>
        </div>
    @endif
@endif

@if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert-inner--text">
            @foreach($errors->all() as $error)
                <p class="mb-0">{{$error}}</p>
            @endforeach
        </div>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-inner--text">{{session()->get('message')}}</span>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="alert-inner--text">{{session()->get('success')}}</span>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-1" role="alert">
        <span class="alert-inner--text">{{session()->get('error')}}</span>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
