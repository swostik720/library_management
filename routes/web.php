<?php

use App\Http\Controllers\AcquisitionRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books
    Route::resource('books', BookController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Transactions
    Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/transactions/{transaction}/return', [TransactionController::class, 'returnBook'])->name('transactions.return');
    Route::get('/transactions/user/{userId}', [TransactionController::class, 'userHistory'])->name('transactions.user-history');
    Route::get('/overdue-books', [TransactionController::class, 'overdueBooks'])->name('transactions.overdue');

    // Acquisition Requests
    Route::resource('acquisition', AcquisitionRequestController::class)->except(['edit', 'update', 'destroy']);
    Route::post('/acquisition/{acquisition}/status', [AcquisitionRequestController::class, 'updateStatus'])->name('acquisition.update-status');

    // Users
    Route::resource('users', UserController::class);

    // Reports (Admin & Librarian only)
    Route::middleware(['role:admin,librarian'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/most-borrowed', [ReportController::class, 'mostBorrowedBooks'])->name('reports.most-borrowed');
        Route::get('/reports/overdue', [ReportController::class, 'overdueList'])->name('reports.overdue');
        Route::get('/reports/user-activity', [ReportController::class, 'userActivity'])->name('reports.user-activity');
        Route::get('/reports/category-popularity', [ReportController::class, 'categoryPopularity'])->name('reports.category-popularity');
    });
});
