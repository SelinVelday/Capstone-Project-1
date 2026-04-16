@extends('layouts.app')

@section('title', 'Detail Event')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                @if($event->banner)
                    <img src="{{ asset('storage/' . $event->banner) }}" class="card-img-top" alt="{{ $event->title }}" style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/800x400?text=QuickTick+Event" class="card-img-top" alt="No Image">
                @endif

                <div class="card-body p-4">
                    <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">{{ $event->category->name ?? 'Umum' }}</span>
                    <h2 class="fw-bold text-dark mb-3">{{ $event->title }}</h2>

                    <h5 class="fw-bold mt-4 mb-2">Deskripsi Acara</h5>
                    <p class="text-muted" style="white-space: pre-line;">{{ $event->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Informasi Pelaksanaan</h5>
                    <ul class="list-unstyled mb-0 text-muted">
                        <li class="mb-3">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <strong>Tanggal:</strong> <br> {{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d F Y') }}
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <strong>Waktu:</strong> <br> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Lokasi:</strong> <br> {{ $event->location }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 border-top border-primary border-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-center mb-1">Pesan Tiket</h5>
                    <p class="text-center text-danger small fw-bold mb-4">Sisa Kuota: {{ $event->quota }} Tiket</p>

                    <form action="{{ route('user.checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="form-group mb-3">
                            <label for="quantity" class="form-label fw-bold">Jumlah Tiket</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $event->quota }}" required>
                                <span class="input-group-text">Tiket</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
