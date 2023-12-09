<?php


use App\Http\Controllers\BookAcquisitionController;
use App\Http\Controllers\BookDeletionController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\AccountHistory;
use App\Http\Controllers\AccHistoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\handleRequests;
use App\Http\Controllers\PatronBookControll;
use App\Http\Controllers\PatronHistoryControl;
use App\Http\Controllers\PatronQueueControl;
use App\Http\Controllers\PatronSearchControl;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\requestsDecision;
use App\Models\pendingRequests;

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

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Patron Dashboard Hompage
Route::get('/patron_dashboard', function () {
    return view('patron_dashboard');
})->middleware(['auth', 'verified'])->name('patron_dashboard');

// Patron Search
Route::get('/patron_search', [PatronSearchControl::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('patron_search');

Route::get('/patron_search/{id}', [PatronBookControll::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('pbook.show');

 Route::post('/patron_search/checkin/{title}', [PatronBookControll::class, 'checkIn'])
    ->middleware(['auth', 'verified'])
    ->name('request.checkIn');

Route::post('/patron_search/checkout/{title}/{sublocation}}', [PatronBookControll::class, 'checkOut'])
    ->middleware(['auth', 'verified'])
    ->name('request.checkOut');

// Patron Queue
Route::get('/patron_queue', [PatronQueueControl::class, 'getUserQueue'])
    ->middleware(['auth', 'verified'])
    ->name('patron_queue');

// Patron History
Route::get('/patron_history', [PatronHistoryControl::class, 'getUserAccountHistory'])
    ->middleware(['auth', 'verified'])
    ->name('patron_history'); 

// Admin Dashboard Homepage
Route::get('/dashboard', [BookController::class, 'showBooksWithHighestCount'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Account History
Route::get('/history', [AccHistoryController::class, 'getUserAccountHistory'])
    ->middleware(['auth', 'verified'])
    ->name('history'); 

// Queue
Route::get('/queue', [QueueController::class, 'getUserQueue'])
    ->middleware(['auth', 'verified'])
    ->name('queue');

// Requests Approval
Route::get('/requests', [handleRequests::class, 'getRequests']) 
    ->middleware(['auth', 'verified'])
    ->name('requests');

Route::post('/requests/{email}/approve', [handleRequests::class, 'approveRequest'])
    ->name('approve-request');

Route::post('/requests/{email}/deny', [handleRequests::class, 'denyRequest'])
    ->name('deny-request');

// Book Management
Route::get('/book_management', function () {
        return view('book_management');
    })->middleware(['auth', 'verified'])->name('book_management');

Route::get('/book_acquisition', [BookAcquisitionController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('book_acquisition');
Route::post('book_acquisition', [BookAcquisitionController::class, 'store']);

Route::get('/book_termination', function () {
    return view('book_termination');
})->middleware(['auth', 'verified'])->name('book_termination');
Route::post('/book_termination', [BookDeletionController::class, 'destroy']);

// Search
Route::get('/search', [SearchController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('search');

Route::get('/search/{id}', [BookController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('book.show');

 Route::post('/search/checkin/{title}', [BookController::class, 'checkIn'])
    ->middleware(['auth', 'verified'])
    ->name('request.checkIn');

Route::post('/search/checkout/{title}/{sublocation}}', [BookController::class, 'checkOut'])
    ->middleware(['auth', 'verified'])
    ->name('request.checkOut');

// Profile Controller
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Temporary Routes


/*
Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
            
    Route::post('register', [RegisteredUserController::class, 'store']);
    
Route::get('/requests', function () {
    return view('requests');
})->middleware(['auth', 'verified'])->name('requests');

Route::get('/history', function () {
    return view('history');
})->middleware(['auth', 'verified'])->name('history');
*/

require __DIR__.'/auth.php';
