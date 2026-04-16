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
        $events = Event::with('category')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Aturan Validasi
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'description' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,draft',
        ];

        // Validasi tambahan jika memilih kategori "Lainnya"
        if ($request->category_id === 'lainnya') {
            $rules['new_category_name'] = 'required|string|max:255|unique:categories,name';
        } else {
            $rules['category_id'] .= '|exists:categories,id';
        }

        $validated = $request->validate($rules);

        // 2. Logika Kategori (Simpan Kategori Baru jika ada)
        if ($request->category_id === 'lainnya') {
            $newCategory = Category::create([
                'name' => $request->new_category_name,
                'slug' => Str::slug($request->new_category_name)
            ]);
            $validated['category_id'] = $newCategory->id;
        }
        unset($validated['new_category_name']); // Hapus agar tidak masuk ke tabel events

        // 3. Upload Banner
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        // 4. Data Otomatis
        $validated['slug'] = Str::slug($validated['title'] . '-' . time());
        $validated['organizer_id'] = Auth::id();

        // 5. Simpan Event
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'date' => 'required|date',
            'start_time' => 'required',
            'location' => 'required|string',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,draft',
        ]);

        $validated['slug'] = Str::slug($validated['title'] . '-' . $event->id);

        if ($request->hasFile('banner')) {
            if ($event->banner && Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        if ($event->banner && Storage::disk('public')->exists($event->banner)) {
            Storage::disk('public')->delete($event->banner);
        }
        $event->delete();
        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }
}
