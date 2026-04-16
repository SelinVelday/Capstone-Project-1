<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($request->event_id);

        if ($event->quota < $request->quantity) {
            return back()->with('error', 'Maaf, kuota tiket tidak mencukupi.');
        }

        // --- MENGHITUNG TOTAL HARGA ---
        $total_price = $event->price * $request->quantity;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'quantity' => $request->quantity,
            // Simpan harga dan set status jadi belum dibayar
            'total_price' => $total_price,
            'booking_code' => 'QT-' . strtoupper(Str::random(6)),
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $event->decrement('quota', $request->quantity);

        return redirect()->route('user.tickets.index')
            ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran untuk kode: ' . $booking->booking_code);
    }

    public function index()
    {
        // Ambil data tiket milik user yang sedang login, urutkan dari yang terbaru
        $bookings = Booking::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.my_tickets', compact('bookings'));
    }

    // Menampilkan halaman upload bukti bayar
    public function payment($id)
    {
        $booking = Booking::with('event')->findOrFail($id);

        // Keamanan: pastikan ini tiket milik user yang login
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        return view('user.payment', compact('booking'));
    }

    // Memproses file bukti bayar yang diupload
    public function uploadReceipt(Request $request, $id)
    {
        $request->validate([
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        $booking = Booking::findOrFail($id);

        if ($request->hasFile('payment_receipt')) {
            $path = $request->file('payment_receipt')->store('receipts', 'public');

            $booking->update([
                'payment_receipt' => $path,
                // Opsional: kita ubah statusnya agar admin tahu ini perlu dicek
                'status' => 'pending',
            ]);
        }

        return redirect()->route('user.tickets.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu konfirmasi dari Admin.');
    }
}
