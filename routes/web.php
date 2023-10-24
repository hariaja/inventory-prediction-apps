<?php

use App\Http\Controllers\Histories\CountController;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\UserController;
use App\Http\Controllers\Masters\ProductController;
use App\Http\Controllers\Masters\MaterialController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Masters\TransactionController;

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
  return redirect(RouteServiceProvider::HOME);
});

require __DIR__ . '/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware([
  'auth',
  'permission',
])->group(function () {
  // Settings Page
  Route::prefix('settings')->group(function () {
    // Role management.
    Route::resource('roles', RoleController::class)->except('show');

    // User management.
    Route::patch('users/status/{user}', [UserController::class, 'status'])->name('users.status');
    Route::resource('users', UserController::class);
  });

  // Management password users.
  Route::get('users/password/{user}', [PasswordController::class, 'showChangePasswordForm'])->name('users.password');
  Route::post('users/password', [PasswordController::class, 'store']);

  Route::prefix('masters')->group(function () {
    // Materials
    Route::resource('materials', MaterialController::class)->except('show');

    // Products
    Route::resource('products', ProductController::class);
  });

  // Transaction
  Route::resource('transactions', TransactionController::class)->except('edit', 'update');

  // Count
  Route::resource('counts', CountController::class)->except('edit', 'update');
});
