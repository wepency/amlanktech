<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AssociationController;
use App\Http\Controllers\Admin\AssociationManagerController;
use App\Http\Controllers\Admin\AssociationMemberController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\InvestmentCompanyContractController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\Admin\OutsourceUserController;
use App\Http\Controllers\Admin\PaymentReceiptController;
use App\Http\Controllers\Admin\ReceiptCategoriesController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\PollController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceCompanyContractController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketMessageController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'form'])->name('login');
Route::post('login', [LoginController::class, 'postLogin'])->name('login.post');
Route::get('login/2fa', [LoginController::class, 'otpForm'])->name('login.otp');
Route::post('login/2fa', [LoginController::class, 'checkOTP'])->name('login.otp.post');

Route::middleware(['admin'])->group(function () {
    Route::get('/', DashboardController::class)->name('home');

    Route::post('logout', LogoutController::class)->name('logout');

    // Requests
    Route::get('units/requests', [\App\Http\Controllers\Admin\RequestController::class, 'requests'])->name('units.requests');
    Route::get('units/{unit}/accept-modal', [\App\Http\Controllers\Admin\RequestController::class, 'acceptModal'])->name('units.accept.modal');
    Route::put('units/{unit}/accept', [\App\Http\Controllers\Admin\RequestController::class, 'accept'])->name('units.accept');

    //Association
    Route::get('associations/manager-form', [AssociationController::class, 'managerForm'])->name('associations.managers.create');
    Route::resource('associations', AssociationController::class)->except('show');

    Route::get('/associations/{association}/download-certificate', [AssociationController::class, 'downloadCertificate'])->name('association.download_certificate');

    Route::get('associations/member-form', [AssociationController::class, 'memberForm'])->name('associations.member.create');
    Route::resource('members', AssociationMemberController::class)->only('index', 'create', 'edit', 'store', 'update', 'destroy');

    Route::get('/members/{member}/address', [AssociationMemberController::class, 'showAddress'])->name('member_address.show');

    Route::get('units/get_association_fees_identifier', [UnitController::class, 'getAssociationFeesIdentifier'])->name('units.get_association_fees_identifier');
    Route::resource('units', UnitController::class);
    Route::get('/units/{unit}/download-instrument', [UnitController::class, 'downloadInstrument'])->name('units.download_instrument');

    Route::resource('employees', UserController::class)->except('show');
    Route::resource('outsource_employees', OutsourceUserController::class);

    Route::resource('subscriptions', SubscriptionController::class)->only('index', 'store', 'update', 'destroy');
    Route::get('/subscriptions/paid', [SubscriptionController::class, 'paid'])->name('subscriptions.paid');
    Route::get('/subscriptions/not-paid', [SubscriptionController::class, 'notPaid'])->name('subscriptions.notPaid');
    Route::get('/subscriptions/late', [SubscriptionController::class, 'late'])->name('subscriptions.late');

    Route::resource('policies', PolicyController::class);
    Route::get('/policies/{policy}/download-policy-file', [PolicyController::class, 'downloadPolicyFile'])->name('policies.download_policy_file');

    //Association Managers
    Route::resource('admins', \App\Http\Controllers\Admin\AdminsController::class)->except('show');
    Route::resource('managers', AssociationManagerController::class)->except('show');

    Route::get('/companies/{company}/agreements', [CompanyController::class, 'agreements'])->name('companies.agreements');

    Route::post('/companies/{company}/agreements/vote', [CompanyController::class, 'vote'])->name('companies.agreements.vote');

    Route::resource('companies', CompanyController::class);

//    Route::get('/companies/{company}/invesment-contract', [CompanyController::class, 'showInvesmentContract'])->name('companies.showInvesmentContract');

    Route::resource('investments', InvestmentCompanyContractController::class);
    Route::get('/investments/{investment}/download-contract', [InvestmentCompanyContractController::class, 'downloadContract'])->name('investments.download_contract');

    Route::resource('services', ServiceCompanyContractController::class);
    Route::get('/services/{service}/download-contract', [ServiceCompanyContractController::class, 'downloadContract'])->name('services.download_contract');

    Route::put('payment-receipts/{paymentReceipt}/accept', [PaymentReceiptController::class, 'accept'])->name('payment-receipts.accept');
    Route::resource('payment-receipts', PaymentReceiptController::class);
    Route::resource('income-receipts', \App\Http\Controllers\Admin\IncomeReceiptController::class);

    Route::resource('receipt-categories', ReceiptCategoriesController::class);

    Route::resource('bills', BillController::class);

    // Polls
    Route::resource('polls', PollController::class);

    Route::resource('invoices', InvoiceController::class)->only('index', 'store', 'update', 'destroy');

    Route::delete('roles/{role}/removeUser/{admin}', RoleController::class . '@removeUser')->name('roles.users.remove');
    Route::resource('roles', RoleController::class)->except('show');

//    Route::get('budget/subscriptions', [\App\Http\Controllers\Admin\BudgetController::class, 'subscriptions'])->name('budget.subscriptions');
    Route::get('budget', [\App\Http\Controllers\Admin\BudgetController::class, 'index'])->name('budget');

    Route::resource('gifts', GiftController::class);

//    Route::resource('announcements', AnnouncementController::class);

    Route::get('posts/{post}/comments', [\App\Http\Controllers\Admin\PostController::class, 'comments'])->name('posts.comments');
    Route::get('posts/{post}/likes', [\App\Http\Controllers\Admin\PostController::class, 'likes'])->name('posts.likes');
    Route::get('posts/{post}/dislikes', [\App\Http\Controllers\Admin\PostController::class, 'dislikes'])->name('posts.dislikes');

    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);

    // Tasks Resource
    Route::resource('tasks', \App\Http\Controllers\Admin\TasksController::class);

    Route::get('meetings/{meeting}/agenda', [MeetingController::class, 'agendaModal'])->name('meetings.agenda.modal');
    Route::put('meetings/{meeting}/agenda', [MeetingController::class, 'agenda'])->name('meetings.agenda');
    Route::post('meetings/{meeting}/agenda/export', [MeetingController::class, 'exportAgenda'])->name('meetings.agenda.export');

    Route::get('meetings/{meeting}/decisions', [MeetingController::class, 'decisionsModal'])->name('meetings.decisions.modal');
    Route::put('meetings/{meeting}/decisions', [MeetingController::class, 'decisions'])->name('meetings.decisions');

    Route::resource('meetings', MeetingController::class);

    Route::put('tickets/{ticket}/change-status/{status}', [TicketController::class, 'changeStatus'])->name('tickets.change_status');
    Route::resource('tickets', TicketController::class);
    Route::resource('ticket-categories', \App\Http\Controllers\Admin\TicketCategoriesController::class);

    // Permits
    Route::get('permits/requests', [\App\Http\Controllers\Admin\PermitsController::class, 'requests'])->name('permits.requests');
    Route::get('permits/visitors-row', [\App\Http\Controllers\Admin\PermitsController::class, 'visitorsRow'])->name('permits.visitors.row');


    Route::get('permits/blocklist', [\App\Http\Controllers\Admin\PermitBlocksController::class, 'index'])->name('permits.blocklist.index');
    Route::get('permits/blocklist/create', [\App\Http\Controllers\Admin\PermitBlocksController::class, 'create'])->name('permits.blocklist.create');
    Route::post('permits/blocklist', [\App\Http\Controllers\Admin\PermitBlocksController::class, 'store'])->name('permits.blocklist.store');
    Route::delete('permits/blocklist/{block}/delete', [\App\Http\Controllers\Admin\PermitBlocksController::class, 'destroy'])->name('permits.blocklist.destroy');

    Route::resource('permits', \App\Http\Controllers\Admin\PermitsController::class)->except('show');

    Route::resource('tickets/{ticket}/messages', TicketMessageController::class)->only('index', 'store', 'update', 'destroy');


    Route::group(['prefix' => 'get'], function () {
        Route::get('associations', [\App\Http\Controllers\API\AssociationController::class, 'getAssociations'])->name('get.associations');
    });
});

Route::prefix('admin/api')->group(function () {
    Route::get('admins', [\App\Http\Controllers\Admin\API\AdminController::class, 'index']);
    Route::get('admins/create', [\App\Http\Controllers\Admin\API\AdminController::class, 'create']);
    Route::post('admins/store', [\App\Http\Controllers\Admin\API\AdminController::class, 'store']);
});

Route::get('permits/{permit?}', [App\Http\Controllers\Admin\PermitsController::class, 'show'])->name('permits.show');;
