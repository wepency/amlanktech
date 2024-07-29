<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('seed', function (){
    \App\Models\Admin::where('email', 'admin@gmail.com')->first()->update([
        'password' => \Illuminate\Support\Facades\Hash::make(123123123)
    ]);

//    Artisan::call('db:seed', [
//        '--class' => 'AdminPermissionsSeeder', // Replace 'YourSeederClassName' with the actual seeder class name
//        '--force' => true, // Use --force flag to run in production environment
//    ]);
//
//    // Get the output of the command
//    $output = Artisan::output();
});

Route::get('/login', [\App\Http\Controllers\LoginController::class, 'form'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'postLogin']);
//Route::get('/about-us', [AboutController::class, 'index']);

Route::get('waiting-approval', [\App\Http\Controllers\LoginController::class, 'waitingApproval']);

Route::post('members/request', [\App\Http\Controllers\MembersController::class, 'memberNewRequest'])->name('member.unit.request');

Route::get('pages/{slug}', [\App\Http\Controllers\PagesController::class, 'page']);

Route::view('about-us', 'Frontend.Pages.about-us');
Route::view('subscriptions', 'Frontend.Pages.subscriptions');
Route::view('services', 'Frontend.Pages.services');
Route::view('contact-us', 'Frontend.Pages.contact-us');

//Route::group(['prefix' => 'pages'], function () {
//    Route::get('request/success', [\App\Http\Controllers\PagesController::class, 'requestSuccess'])->name('request.success');
//});

Route::group(['middleware' => 'associationMember'], function () {

    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'postLogout'])->name('logout');

    // Ads
    //Route::get('ads', [\App\Http\Controllers\AdsController::class, 'index']);
    //Route::get('ads/{ad}', [\App\Http\Controllers\AdsController::class, 'show']);

    // Units
    //Route::resource('units', \App\Http\Controllers\AdsController::class);

    // Meetings
    //Route::get('meetings/{meeting}', [\App\Http\Controllers\AdsController::class, 'index']);

    // Payments
    // Tickets


    Route::resource('tickets', \App\Http\Controllers\TicketsController::class)->except('create', 'store');

    Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);

});

Route::get('permits/{permit?}', [\App\Http\Controllers\PermitsController::class, 'show'])->name('permits.show');
