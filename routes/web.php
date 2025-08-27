<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProgramController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Student routes
Route::middleware(['auth', 'verified'])->name('student.')->group(function () {
    Route::get('/student/dashboard', [ApplicationController::class, 'index'])->name('dashboard');
    Route::get('/student/application/create', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/student/application', [ApplicationController::class, 'store'])->name('application.store');
    Route::get('/student/application/{application}', [ApplicationController::class, 'show'])->name('application.show');
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Applications management
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications.index');
    Route::get('/applications/{application}', [AdminController::class, 'showApplication'])->name('applications.show');
    Route::patch('/applications/{application}/status', [AdminController::class, 'updateStatus'])->name('applications.update-status');
    Route::get('/applications/export/csv', [AdminController::class, 'exportCsv'])->name('applications.export-csv');
    
    // Programs management
    Route::resource('programs', ProgramController::class);
    Route::patch('/programs/{program}/toggle-status', [ProgramController::class, 'toggleStatus'])->name('programs.toggle-status');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
