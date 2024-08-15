<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', \App\Http\Controllers\API\LoginController::class);
Route::post('register', \App\Http\Controllers\API\RegisterController::class);

// Plans
Route::get('plans', [\App\Http\Controllers\API\PlansController::class, 'index']);
Route::get('plans/{plan}', [\App\Http\Controllers\API\PlansController::class, 'show']);

// Association & Manage sign up
Route::post('associations/register', [\App\Http\Controllers\API\AssociationRegisterController::class, 'store']);

Route::group(['prefix' => 'lists'], function () {

    // Associations
    Route::get('associations', [\App\Http\Controllers\API\AssociationsController::class, 'index']);

    // Units
    Route::get('units', [\App\Http\Controllers\API\ListsController::class, 'units']);

    // Ticket categories
    Route::get('ticket-categories', [\App\Http\Controllers\API\ListsController::class, 'ticketCategories']);

});

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['prefix' => 'account'], function () {
        Route::get('me', [\App\Http\Controllers\API\AccountController::class, 'me']);
    });

    Route::middleware('ValidatedUser')->group(function () {

        Route::get('posts', [\App\Http\Controllers\API\PostsController::class, 'index']);
        Route::get('posts/{post}', [\App\Http\Controllers\API\PostsController::class, 'show']);

        Route::post('posts/{post}/add-comment', [\App\Http\Controllers\API\PostsController::class, 'storeComment']);
        Route::delete('comments/{comment}', [\App\Http\Controllers\API\PostsController::class, 'deleteComment']);

        // Update Reactions
        Route::post('posts/{post}/update-reactions', [\App\Http\Controllers\API\PostsController::class, 'updateReactions']);

        // System Documents
        Route::get('system-documents', \App\Http\Controllers\API\SystemDocumentController::class);

        // Association System
        Route::get('association-systems', \App\Http\Controllers\API\AssociationSystemController::class);

        // Meetings
        Route::get('meetings', [\App\Http\Controllers\API\MeetingsController::class, 'index']);
        Route::get('meetings/{meeting}', [\App\Http\Controllers\API\MeetingsController::class, 'show']);
        Route::get('meetings/{meeting}/can-join', [\App\Http\Controllers\API\MeetingsController::class, 'canJoin']);

        // Units
        Route::post('units/{unit}', [\App\Http\Controllers\API\UnitsController::class, 'update']);
        Route::resource('units', \App\Http\Controllers\API\UnitsController::class)->except('create', 'edit');

        // Support Tickets
        Route::group(['prefix' => 'support-tickets'], function () {
            Route::get('/', [\App\Http\Controllers\API\SupportTicketsController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\API\SupportTicketsController::class, 'store']);
            Route::get('/{ticket}', [\App\Http\Controllers\API\SupportTicketsController::class, 'show']);
            Route::post('/{ticket}/reply', [\App\Http\Controllers\API\SupportTicketsController::class, 'addReply']);
            Route::post('/reply/{reply}/add-stars', [\App\Http\Controllers\API\SupportTicketsController::class, 'addRatingToReply']);
            Route::delete('/replies/{message}', [\App\Http\Controllers\API\SupportTicketsController::class, 'deleteReply']);

            Route::get('/{ticket}/others', [\App\Http\Controllers\API\SupportTicketsController::class, 'others']);
            Route::get('/{ticket}/attachments', [\App\Http\Controllers\API\SupportTicketsController::class, 'attachments']);

            // Apply an appeal
            Route::post('/{ticket}/apply-appeal', [\App\Http\Controllers\API\SupportTicketsController::class, 'applyAppeal']);
        });

        // Subscriptions
        Route::get('subscriptions', [\App\Http\Controllers\API\SubscriptionsController::class, 'index']);
        Route::get('subscriptions/{subscription}', [\App\Http\Controllers\API\SubscriptionsController::class, 'show']);

        // Permits
        Route::post('permits/{permit}', [\App\Http\Controllers\API\PermitsController::class, 'update']);
        Route::resource('permits', \App\Http\Controllers\API\PermitsController::class)->except('create', 'edit');

        // Polls
        Route::get('polls', [\App\Http\Controllers\API\PollsController::class, 'index']);
        Route::get('polls/{poll}', [\App\Http\Controllers\API\PollsController::class, 'show']);
        Route::post('polls/{poll}/toggle-vote', [\App\Http\Controllers\API\PollsController::class, 'toggleVote']);
    });

});

// Dashboard API
Route::prefix('dashboard')->group(function () {
    Route::get('provinces', [\App\Http\Controllers\API\ProvincesController::class, 'list']);
    Route::get('cities/{province?}', [\App\Http\Controllers\API\CitiesController::class, 'list']);

    Route::get('association/{association}/fee-type-form', [\App\Http\Controllers\API\AssociationController::class, 'feeTypeForm']);
});

Route::get('getAssociationFeesLabel/{association}', [\App\Http\Controllers\API\AssociationController::class, 'getAssociationFeesLabel']);

// Contact us end-point
Route::post('contact-us', \App\Http\Controllers\API\ContactUsController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
