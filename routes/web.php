<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
// Asumsi controller di bawah ini akan kita buat nanti untuk melengkapi fitur
use App\Http\Controllers\TicketTypeController; 
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\BookingController; 
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

// ==========================================
// 1. HALAMAN DEPAN (PUBLIC)
// ==========================================
Route::get('/', function () {
    // Bisa diarahkan ke landing page, tapi untuk sekarang kita arahkan ke login saja
    return redirect()->route('login');
});

// ==========================================
// 2. ROUTING PINTAR (SMART REDIRECT)
// ==========================================
// Bawaan Breeze selalu mengarah ke '/dashboard' setelah login.
// Kita buat logika: Jika yang login Admin, lempar ke panel Admin. Jika User, lempar ke User.
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.events.index');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// 3. PENGATURAN PROFIL (BAWAAN BREEZE)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ==========================================
// 4. PANEL ADMIN (Hanya boleh diakses Admin)
// ==========================================
// Catatan: Pastikan Anda sudah membuat middleware 'role' (misal: CheckRole) 
// Jika belum ada middleware khusus, sementara hapus 'role:admin' dari array middleware di bawah ini.
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // CRUD Event (Index, Create, Store, Edit, Update, Destroy otomatis dibuat)
    Route::resource('events', EventController::class);
    
    // Kelola Jenis Tiket untuk Event Tertentu (VIP, Reguler, dll)
    // Rute ini kita siapkan untuk langkah selanjutnya
    Route::get('events/{event}/tickets', [TicketTypeController::class, 'index'])->name('events.tickets.index');
    Route::post('events/{event}/tickets', [TicketTypeController::class, 'store'])->name('events.tickets.store');
    Route::delete('tickets/{ticket}', [TicketTypeController::class, 'destroy'])->name('tickets.destroy');

});


// ==========================================
// 5. PANEL USER / PENGUNJUNG (Katalog & Transaksi)
// ==========================================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    
    // Halaman Katalog Event
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Halaman Detail Event
    Route::get('/event/{slug}', [DashboardController::class, 'show'])->name('event.show');
    
    // Rute untuk Checkout dan Tiket Saya (Persiapan langkah selanjutnya)
    // Route::post('/checkout', [BookingController::class, 'store'])->name('checkout.store');
    // Route::get('/my-tickets', [BookingController::class, 'index'])->name('tickets.index');

});

// Load routing autentikasi bawaan Laravel Breeze (Login, Register, Lupa Password)
require __DIR__.'/auth.php';