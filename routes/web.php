<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. HALAMAN DEPAN (PUBLIC)
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// 2. ROUTING PINTAR (SMART REDIRECT)
// ==========================================
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
// 4. PANEL ADMIN
// ==========================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class);
    Route::get('events/{event}/tickets', [TicketTypeController::class, 'index'])->name('events.tickets.index');
    Route::post('events/{event}/tickets', [TicketTypeController::class, 'store'])->name('events.tickets.store');
    Route::delete('tickets/{ticket}', [TicketTypeController::class, 'destroy'])->name('tickets.destroy');

    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('admin.bookings.index');
    Route::post('/bookings/approve/{id}', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('admin.bookings.approve');
});


// ==========================================
// 5. PANEL USER (Katalog & Transaksi)
// ==========================================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // Halaman Utama User (Katalog)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Detail Event (Rute yang dipanggil oleh tombol di Card)
    Route::get('/events/{slug}', [DashboardController::class, 'show'])->name('event.show');

    // Transaksi & Tiket (Bisa dipakai nanti)
    Route::post('/checkout', [BookingController::class, 'store'])->name('checkout.store');
    Route::get('/my-tickets', [BookingController::class, 'index'])->name('tickets.index');

    Route::get('/payment/{id}', [\App\Http\Controllers\User\BookingController::class, 'payment'])->name('user.payment');
    Route::post('/payment/{id}', [\App\Http\Controllers\User\BookingController::class, 'uploadReceipt'])->name('user.payment.process');

});

require __DIR__.'/auth.php';
