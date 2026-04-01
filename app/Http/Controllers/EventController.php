<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        // Menampilkan semua event beserta nama kategorinya
        $events = Event::with('category')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        // Mengambil data kategori untuk dropdown
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input dan simpan ke dalam array $validated
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,draft',
        ]);

        // 2. Upload Banner
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        // 3. Tambahkan data otomatis (Slug & Organizer ID)
        $validated['slug'] = Str::slug($validated['title'] . '-' . time()); // Slug unik
        $validated['organizer_id'] = Auth::id(); // ID Admin/Organizer yang sedang login

        // 4. Simpan ke Database (Lebih aman menggunakan $validated)
        Event::create($validated);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional
            'date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,draft',
        ]);

        // 2. Perbarui Slug
        $validated['slug'] = Str::slug($validated['title'] . '-' . $event->id);

        // 3. Cek jika ada upload banner baru
        if ($request->hasFile('banner')) {
            // Hapus banner lama dari storage jika ada
            if ($event->banner && Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }
            // Simpan path banner baru ke dalam array validated
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        } else {
            // Hapus key 'banner' dari array jika tidak ada file baru
            // agar path banner yang lama tidak tertimpa menjadi null
            unset($validated['banner']);
        }

        // 4. Update Database
        $event->update($validated);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        // Hapus file gambar dari storage dengan pengecekan aman
        if ($event->banner && Storage::disk('public')->exists($event->banner)) {
            Storage::disk('public')->delete($event->banner);
        }
        
        $event->delete();

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil dihapus!');
    }
}