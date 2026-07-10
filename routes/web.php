<?php

use App\Http\Controllers\Backend\Admin\GudepController;
use App\Http\Controllers\Backend\Admin\KegiatanController;
use App\Http\Controllers\Backend\Admin\MainController;
use App\Http\Controllers\Backend\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\Backend\Admin\RantingController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\User\GudepController as UserGudepController;
use App\Http\Controllers\Backend\User\PendaftaranController as UserPendaftaranController;
use App\Http\Controllers\Frondend\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Kegiatan;
use App\Models\Kegiatan_partisipan;
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

// Detail kegiatan menggunakan pola URL /kegiatan/detail/{id}
Route::get('/kegiatan/detail/{id}', [HomeController::class, 'get_kegiatanDetail'])->name('kegiatan.detail');

Route::get('/dashboard', function () {
    $gudep = auth()->user()->gudep->first();

    $totalKegiatanTersedia = Kegiatan::where('date', '>=', date('Y-m-d'))->count();
    $totalPartisipasi = $gudep ? Kegiatan_partisipan::where('gudeps_id', $gudep->id)->count() : 0;

    $kegiatanMendatang = Kegiatan::where('date', '>=', date('Y-m-d'))->orderBy('date')->take(5)->get();

    $partisipasiSaya = $gudep
        ? Kegiatan_partisipan::with('kegiatan')->where('gudeps_id', $gudep->id)->latest()->take(5)->get()
        : collect();

    return view('dashboard', compact('gudep', 'totalKegiatanTersedia', 'totalPartisipasi', 'kegiatanMendatang', 'partisipasiSaya'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::auto('/', MainController::class);

    Route::middleware('admin')->group(function () {
        Route::auto('/data/kegiatan', KegiatanController::class);
        Route::auto('/data/ranting', RantingController::class);
        Route::auto('/data/gudep', GudepController::class);
        Route::auto('/data/user', UserController::class);
        Route::auto('/pendaftaran', AdminPendaftaranController::class);
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
