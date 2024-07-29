<div class="row">
    <div class="col-sm-6 col-lg-4">
        <div class="card card-img-holder">
            <div class="card-body list-icons pb-0">
                <div class="clearfix">
                    <div class="float-end mt-2">
                      <span class="text-primary ">
                        <i class="si si-docs tx-30"></i>
                      </span>
                    </div>

                    <div class="float-start">
                        <p class="card-text text-muted mb-1">إجمالي الميزانية</p>
                        <h3 id="budget-total">{{cache()->get('budget_' . getAssociationId() ?? 0)}}</h3>
                    </div>
                </div>
            </div>

            <div class="static-footer p-2">
                <span class="info-balloon" data-bs-toggle="tooltip" title="جميع العقود التي تم اصدارها">
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
                          <i class="si si-check tx-30"></i>
                      </span>
                    </div>

                    <div class="float-start">
                        <p class="card-text text-muted mb-1">مدخلات</p>
                        <h3 id="income-total">0</h3>
                    </div>
                </div>
            </div>

            <div class="static-footer p-2">
                <span class="info-balloon" data-bs-toggle="tooltip" title="بانتظار تفعيل رقم الجوال">
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
                          <i class="si si-check tx-30"></i>
                      </span>
                    </div>
                    <div class="float-start">
                        <p class="card-text text-muted mb-1">مصروفات</p>
                        <h3 id="payment-total">0</h3>
                    </div>
                </div>
            </div>

            <div class="static-footer p-2">
                <span class="info-balloon" data-bs-toggle="tooltip" title="العقود الفعاله">
                    <i class="fa fa-question"></i>
                </span>
            </div>
        </div>
    </div>
</div>
