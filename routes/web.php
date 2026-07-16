<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JamaahController as AdminJamaahController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Jamaah\DashboardController;
use App\Http\Controllers\Jamaah\PaketController;
use App\Http\Controllers\Jamaah\PembayaranController;
use App\Http\Controllers\Jamaah\PendaftaranController;
use App\Http\Controllers\Jamaah\ProfileController;
use App\Models\Visitor;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $pakets = \App\Models\PaketUmrah::where('status', 'aktif')
        ->withCount('pendaftaranKuota as pendaftaran_kuota_count')
        ->orderBy('harga')
        ->get()
        ->filter(fn ($p) => $p->kuota === null || $p->kuota_terpakai < $p->kuota)
        ->take(3);

    $totalVisitors = Visitor::count();
    $jamaahCount = \App\Models\Jamaah::count();
    $kloterCount = \App\Models\PaketUmrah::count();

    return view('welcome', [
        'pakets' => $pakets,
        'totalVisitors' => $totalVisitors,
        'jamaahCount' => $jamaahCount,
        'kloterCount' => $kloterCount,
    ]);
})->middleware('visitor')->name('home');

/*
|--------------------------------------------------------------------------
| Auth Routes (guest only)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Forgot Password + OTP + Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot.password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('forgot.password.send');

    Route::get('/verify-otp', function () {
        if (! session('otp')) {
            return redirect()->route('forgot.password');
        }

        return view('auth.verify-otp');
    })->name('verify.otp');
    Route::post('/verify-otp', [OtpController::class, 'verify'])->name('verify.otp.post');

    Route::get('/new-password', function () {
        if (! session('otp_verified')) {
            return redirect()->route('forgot.password');
        }

        return view('auth.new-password');
    })->name('new-password');
    Route::post('/update-password', [ResetPasswordController::class, 'update'])->name('password.update');
});

// Logout (auth only)
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Jamaah Routes (auth + jamaah role)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'jamaah'])->group(function () {
    // Dashboard jamaah
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Paket Umrah
    Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
    Route::get('/paket/{id}', [PaketController::class, 'show'])->name('paket.detail');

    // Pendaftaran
    Route::get('/status-pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::post('/pendaftaran/{id}/draft', [PendaftaranController::class, 'draft'])->name('pendaftaran.draft');
    Route::post('/pendaftaran/{id}/submit', [PendaftaranController::class, 'submit'])->name('pendaftaran.submit');

    // Pembayaran
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/confirm', [PembayaranController::class, 'confirm'])->name('pembayaran.confirm');
    Route::get('/pembayaran/{id}/status/{pembayaran}', [PembayaranController::class, 'status'])->name('pembayaran.status');
    Route::get('/pembayaran/{id}/invoice/{pembayaran}', [PembayaranController::class, 'invoice'])->name('pembayaran.invoice');

    // Notifikasi
    Route::post('/notifikasi/{id}/baca', [DashboardController::class, 'tandaiDibaca'])->name('notifikasi.baca');

    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (auth + admin role)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Jamaah
    Route::get('/jamaah', [AdminJamaahController::class, 'index'])->name('jamaah');
    Route::get('/jamaah/{id}', [AdminJamaahController::class, 'show'])->name('jamaah.detail');
    Route::put('/jamaah/{id}', [AdminJamaahController::class, 'update'])->name('jamaah.update');
    Route::post('/jamaah/{id}/verify', [AdminJamaahController::class, 'verify'])->name('jamaah.verify');
    Route::delete('/jamaah/{id}', [AdminJamaahController::class, 'destroy'])->name('jamaah.destroy');
    Route::get('/belum-verifikasi', [AdminJamaahController::class, 'belumVerifikasi'])->name('belum.verifikasi');

    // Paket Umrah
    Route::get('/paket', [AdminPaketController::class, 'index'])->name('paket');
    Route::post('/paket', [AdminPaketController::class, 'store'])->name('paket.store');
    Route::put('/paket/{id}', [AdminPaketController::class, 'update'])->name('paket.update');
    Route::delete('/paket/{id}', [AdminPaketController::class, 'destroy'])->name('paket.destroy');

    // Pendaftaran
    Route::get('/pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran');
    Route::post('/pendaftaran/{id}/status', [AdminPendaftaranController::class, 'updateStatus'])->name('pendaftaran.status');

    // Pembayaran
    Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran');
    Route::post('/pembayaran/{id}/status', [AdminPembayaranController::class, 'updateStatus'])->name('pembayaran.status');
    Route::get('/pembayaran/export', [AdminPembayaranController::class, 'export'])->name('pembayaran.export');
    Route::get('/pembayaran/{id}/invoice', [AdminPembayaranController::class, 'invoice'])->name('pembayaran.invoice');
});
