<?php

use App\Http\Controllers\Backend\Admin\GudepController;
use App\Http\Controllers\Backend\Admin\KegiatanController;
use App\Http\Controllers\Backend\Admin\MainController;
use App\Http\Controllers\Backend\Admin\RantingController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\User\GudepController as UserGudepController;
use App\Http\Controllers\Backend\User\PendaftaranController as UserPendaftaranController;
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
        Route::auto('/data/kegiatan', KegiatanController::class);
        Route::auto('/data/ranting', RantingController::class);
        Route::auto('/data/gudep', GudepController::class);
        Route::auto('/data/user', UserController::class);
    });

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::auto('/user/data/gudep', UserGudepController::class);
    Route::auto('/user/pendaftaran', UserPendaftaranController::class);
});

require __DIR__.'/auth.php';
