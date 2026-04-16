<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        // Mengambil semua data booking beserta relasi user dan event
        $bookings = Booking::with(['user', 'event'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        // Ubah status jadi paid dan confirmed
        $booking->update([
            'payment_status' => 'paid',
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}
