<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" class="avatar avatar-xl brround" src="{{get_user_image('admin')}}"><span
                    class="avatar-status profile-status bg-green"></span>
            </div>

            <div class="user-info">
                <h4 class="fw-semibold mt-3 mb-0">{{auth('admin')->user()->name}}</h4>
                <h6>{{get_user_title()}}</h6>
            </div>
        </div>
    </div>

    <div class="slide-left disabled" id="slide-left">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/>
        </svg>
    </div>

    @include('Admin.Layouts.Partials._side-menu')

    <div class="slide-right" id="slide-right">
        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/>
        </svg>
    </div>
</div>
