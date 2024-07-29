<div class="row">

    <div class="col-sm-6 col-lg-4">
        <div class="card card-img-holder">
            <div class="card-body list-icons pb-0">
                <div class="clearfix">
                    <div class="float-end mt-2">
                      <span class="text-primary ">
                        <i class="si si-list tx-30"></i>
                      </span>
                    </div>

                    <div class="float-start">
                        <p class="card-text text-muted mb-1">عدد المهام</p>
                        <h3 id="tasks-total">{{$tasks->count()}}</h3>
                    </div>
                </div>
            </div>

            <div class="static-footer p-2">
                <span class="info-balloon" data-bs-toggle="tooltip" title="اجمالي عدد المهام المنجزة">
                    <i class="fa fa-question"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card card-img-holder">
            <div class="card-body list-icons pb-0">
                <div class="clearfix">
                    <div class="float-end mt-2">
                      <span class="text-success">
                          <i class="mdi mdi-check tx-30"></i>
                      </span>
                    </div>

                    <div class="float-start">
                        <p class="card-text text-muted mb-1">المهام المنجزة</p>
                        <h3 id="finished-tasks-total">{{$finished_count}}</h3>
                    </div>
                </div>
            </div>

            <div class="static-footer p-2">
                <span class="info-balloon" data-bs-toggle="tooltip" title="اجمالي عدد المهام المنجزة حتى الأن">
                    <i class="fa fa-question"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card card-img-holder">
            <div class="card-body list-icons pb-0">
                <div class="clearfix">
                    <div class="float-end mt-2">
                      <span class="text-warning">
                          <i class="mdi mdi-loading tx-30"></i>
                      </span>
                    </div>
                    <div class="float-start">
                        <p class="card-text text-muted mb-1">مهام بانتظار الانجاز</p>
                        <h3 id="pending-tasks-total">{{$unfinished_count}}</h3>
                    </div>
                </div>
            </div>

            <div class="static-footer p-2">
                <span class="info-balloon" data-bs-toggle="tooltip" title="مهام بانتظار الانجاز">
                    <i class="fa fa-question"></i>
                </span>
            </div>
        </div>
    </div>

</div>
