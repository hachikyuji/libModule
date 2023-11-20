<?php

use App\Http\Controllers\PatronAuthenticationController;
use App\Livewire\AdminDashboard;
use App\Livewire\HomePage;
use App\Livewire\StudentDashboard;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;

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
    return view('db_connect');
});



Route::get('/login', HomePage::class);
Route::post('/login', [PatronAuthenticationController::class, 'login'])->name('login');

Route::get('/HomeStudent', StudentDashboard::class);
Route::get('/dashboard/patron', StudentDashboard::class)->name('student.dashboard');

Route::get('/HomeAdmin', AdminDashboard::class);
Route::get('/dashboard/admin', AdminDashboard::class)->name('admin.dashboard');

