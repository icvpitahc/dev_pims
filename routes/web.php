<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Livewire\Pages\Home;
use App\Http\Livewire\Pages\InactiveAccount;
use App\Http\Livewire\Pages\NoAccess;
use App\Http\Livewire\Pages\NoAdminAccess;
use App\Http\Livewire\Pages\ModuleSelector;
use App\Http\Livewire\Pages\Calendar;
use App\Http\Livewire\Pages\Css\Results\CssResults;
use App\Http\Livewire\Pages\Css\Results\CssResultsTransactingOffice;
use App\Http\Livewire\Pages\Css\Responses\ListCssResponses;
use App\Http\Livewire\Pages\Css\Responses\ViewCssResponse;
use App\Http\Livewire\Pages\Css\CssForm;
use App\Http\Livewire\Pages\Admin\ListUsers;
use App\Http\Livewire\Pages\Admin\Settings;
use App\Http\Livewire\Pages\Admin\References;
use App\Http\Controllers\DocumentController;
use App\Http\Livewire\Pages\DocumentTracking\Listdocuments;
use App\Http\Livewire\Pages\IctRequest\ListIctRequests;
use App\Http\Livewire\Pages\Issuance\ListIssuances;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/pages/css/css-form', CssForm::class)->name('css-form');
Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth', 'verified', 'activated.account']], function(){
    Route::get('/pages/home', Home::class)->name('home');
    Route::get('/pages/css/responses/view-css-response/{param}', ViewCssResponse::class)->name('view-css-response');
    Route::get('/pages/module-selector', ModuleSelector::class)->name('module-selector');
    Route::get('/pages/calendar', Calendar::class)->name('calendar');
    Route::get('/pages/css/results/css-results/{param}', CssResults::class)->name('css-results');
    Route::get('/pages/css/results/css-results-transacting-office/{param1}/{param2}', CssResultsTransactingOffice::class)->name('css-results-transacting-office');
    Route::get('/pages/css/responses/list-css-responses', ListCssResponses::class)->name('list-css-responses');
    
    // Admin Routes with admin.access middleware
    Route::group(['middleware' => ['admin.access']], function () {
        Route::get('/pages/admin/list-users', ListUsers::class)->name('list-users');
        Route::get('/pages/admin/settings', Settings::class)->name('settings');
        Route::get('/pages/admin/references', References::class)->name('references');
    });

    Route::get('/pages/document-tracking/list-documents', ListDocuments::class)->name('list-documents');
    Route::get('/documents/{document}/print', [DocumentController::class, 'print'])->name('documents.print');
    Route::get('/pages/ict-request/list-ict-requests', ListIctRequests::class)->name('list-ict-requests');
    Route::get('/pages/issuance/list-issuances/', ListIssuances::class)->name('list-issuances');
});

Route::get('/email/verify', Verify::class)->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/pages/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/pages/no-admin-access', NoAdminAccess::class)->name('no-admin-access');
Route::get('/pages/no-access', NoAccess::class)->name('no-access');
Route::get('/pages/inactive-account', InactiveAccount::class)->name('inactive-account');
Auth::routes();
