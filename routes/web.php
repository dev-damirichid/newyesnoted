<?php

use App\Models\Board_user;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ListCardController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChecklistDetailController;

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

// Start Home
Route::get('/', function () {
    return redirect()->route('login');
    return view('welcome');
});
// End Home

## START GUEST ##
Route::middleware(['guest'])->group(function () {
    // Start Login
    Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login');
    // End Login
    // Start Register
    Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])->name('register');
    // End Register
    // Start Forgot Password
    Route::match(['get', 'post'], '/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    // End Forgot Password
    // Start Reset Password
    Route::match(['get', 'post'], '/reset-password/{token}', [AuthController::class, 'resetPasswordToken'])->name('reset-password');
    // End Reset Password
});
// Start Verify Email
Route::get('/verified/{token}', [AuthController::class, 'verifiedToken'])->name('verified-token');
// End Verify Email
## END GUEST ##

## START AUTHENTICATION ##
Route::middleware('auth')->group(function () {
    // Start Verify Email
    Route::match(['get', 'post'], '/verified', [AuthController::class, 'verified'])->name('verified');
    // Start Verify Email
    // Start Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Start Logout

    Route::middleware('ifverified')->group(function () {
        // Start Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        // End Profile

        // Start Dashboard
        Route::get('/d', [DashboardController::class, 'index'])->name('dashboard.index');
        // Start Dashboard

        // Start Board
        Route::get('/b', [BoardController::class, 'index'])->name('board.index');
        Route::get('/b/create', [BoardController::class, 'create'])->name('board.create');
        Route::post('/b', [BoardController::class, 'store'])->name('board.store');
        Route::post('/b-user', [BoardController::class, 'storeUser'])->name('board.store.user');
        Route::delete('/b/{slug}', [BoardController::class, 'destroy'])->name('board.destroy');
        Route::delete('/b-user/{id}', [BoardController::class, 'destroyUser'])->name('board.destroy.user');
        Route::get('/b/{slug}/user', [BoardController::class, 'showUser'])->name('board.show.user');
        Route::put('/b-rename/{slug}', [BoardController::class, 'updateTitle'])->name('board.update.title');

        Route::get('/board/invite/{board}', [BoardController::class, 'userInvite'])->name('board.invite');
        // End Board

        //  Start List Card
            // Start Card Numbering
            Route::get('/list-numbering', [ListCardController::class, 'numbering'])->name('list-card.numbering');
            // End Card Numbering
        Route::get('/lc/{board}', [ListCardController::class, 'index'])->name('list-card.index');
        Route::get('/lc/{board}/create', [ListCardController::class, 'create'])->name('list-card.create');
        Route::post('/lc/{board}', [ListCardController::class, 'store'])->name('list-card.store');
        Route::put('/lc/{list_card}', [ListCardController::class, 'updateTitle'])->name('list-card.update.title');
        Route::delete('/lc/{list_card}', [ListCardController::class, 'destroy'])->name('list-card.destroy');
        //  End List Card

        // Start Card
            // Start Card Numbering
            Route::get('/card-numbering', [CardController::class, 'numbering'])->name('card.numbering');
            // End Card Numbering

        Route::get('/c/{board}/{list_card}/create', [CardController::class, 'create'])->name('card.create');
        Route::delete('/c/{card}', [CardController::class, 'destroy'])->name('card.destroy');
        Route::get('/c-user/{board}/{list_card}/{card}', [CardController::class, 'user'])->name('card.user');
        Route::get('/c-des/{board}/{list_card}/{card}', [CardController::class, 'editDescription'])->name('card.edit.description');
        Route::get('/c-des/{board}/{list_card}/{card}/estimate', [CardController::class, 'editEstimate'])->name('card.edit.estimate');
        Route::put('/c-des/{board}/{list_card}/{card}', [CardController::class, 'updateDescription'])->name('card.update.description');
        Route::put('/c-des/{board}/{list_card}/{card}/estimate', [CardController::class, 'updateEstimate'])->name('card.update.estimate');
        Route::post('/c-user/{board}/{list_card}/{card}', [CardController::class, 'storeUser'])->name('card.store.user');
        Route::delete('/c-user/{board}/{list_card}/{card}/{id}', [CardController::class, 'destroyUser'])->name('card.destroy.user');
        Route::post('/c/{board}/{list_card}', [CardController::class, 'store'])->name('card.store');
        Route::put('/c-rename/{card}', [CardController::class, 'updateTitle'])->name('card.update.title');
        Route::get('/c/{board}/{list_card}/{card}', [CardController::class, 'index'])->name('card.index');

        Route::get('/card/{card}', [CardController::class, 'card'])->name('card.show');
        // End Detail Card

        // Start Label
        Route::get('/l/{card}', [LabelController::class, 'index'])->name('label.index');
        // End Label

        // Start Checklist
        Route::get('/ch/{board}/{list_card}/{card}/checklist', [CheckListController::class, 'create'])->name('checklist.create');
        Route::post('/ch/{board}/{list_card}/{card}/checklist', [CheckListController::class, 'store'])->name('checklist.store');
        Route::delete('ch/{checklist}', [CheckListController::class, 'delete'])->name('checklist.delete');
        // End Checklist

        // Start Detail Card
        Route::get('cd/{checklist}', [ChecklistDetailController::class, 'index'])->name('checklist-detail.index');
        Route::get('/cd/{checklist}/create', [ChecklistDetailController::class, 'create'])->name('checklis-detail.create');
        Route::get('/cd/{checklist}/{checklist_detail}', [ChecklistDetailController::class, 'edit'])->name('checklist-detail.edit');
        Route::put('/cd/{checklist}/{checklist_detail}', [ChecklistDetailController::class, 'update'])->name('checklis-detail.update');
        Route::post('/cd/{checklist}', [ChecklistDetailController::class, 'store'])->name('checklis-detail.store');
        Route::delete('/cd/{checklist_detail}', [ChecklistDetailController::class, 'destroy'])->name('checklis-detail.destroy');
        Route::post('/cd/{checklist_detail}/status-change', [ChecklistDetailController::class, 'status'])->name('checklis-detail.status');
        Route::put('/cd-rename/{checklist}', [ChecklistDetailController::class, 'updateTitle'])->name('checklist.update.title');
        Route::put('/check-rename/{checklist_detail}', [ChecklistDetailController::class, 'updateCheckTitle'])->name('checklist_detail.update.title');
        Route::put('/check-change/{checklist_detail}', [ChecklistDetailController::class, 'updateCheck'])->name('checklist_detail.update.check');
        // End Detail Card

        // Start Calendar
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        // End Calendar
    });
});
## END AUTHENTICATION ##


