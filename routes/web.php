<?php

use App\Http\Controllers\Backend\Admin\GudepController;
use App\Http\Controllers\Backend\Admin\MainController;
use App\Http\Controllers\Backend\Admin\RantingController;
use App\Http\Controllers\Frondend\HomeController;
use App\Http\Controllers\ProfileController;
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

Route::auto('/', HomeController::class);

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::auto('/', MainController::class);

    Route::middleware('admin')->group(function () {
        Route::auto('/data/ranting', RantingController::class);
        Route::auto('/data/gudep', GudepController::class);
    });

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
