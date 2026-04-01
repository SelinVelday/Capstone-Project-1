<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    // Tampilkan halaman kelola tiket untuk event tertentu
    public function index(Event $event)
    {
        // Ambil tiket yang terhubung dengan event ini
        $tickets = $event->ticketTypes;
        return view('admin.events.tickets', compact('event', 'tickets'));
    }

    // Simpan jenis tiket baru
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
        ]);

        $event->ticketTypes()->create([
            'name' => $request->name,
            'price' => $request->price,
            'quota' => $request->quota,
        ]);

        return redirect()->back()->with('success', 'Jenis tiket berhasil ditambahkan!');
    }

    // Hapus jenis tiket
    public function destroy(TicketType $ticket)
    {
        $ticket->delete();
        return redirect()->back()->with('success', 'Jenis tiket berhasil dihapus!');
    }
}