<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Menampilkan katalog event di dashboard user
        $events = Event::with('category')
                       ->where('status', 'active')
                       ->orderBy('date', 'asc')
                       ->get();

        return view('user.dashboard', compact('events'));
    }

    // Fungsi baru untuk melihat detail event
    public function show($slug)
    {
        // Ambil data event beserta kategori dan jenis tiketnya
        // Pastikan Anda sudah punya model TicketType dan relasinya di model Event
        $event = Event::with(['category', 'ticketTypes'])->where('slug', $slug)->firstOrFail();
        
        return view('user.event_detail', compact('event'));
    }
}