@extends('layouts.app')

@section('title', 'Katalog Event')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-stats card-round shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Selamat Datang di QuickTick</p>
                                <h4 class="card-title mb-0">Temukan Event Menarik Untukmu!</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($events->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-primary shadow-sm" role="alert">
                    <i class="fas fa-info-circle me-2"></i> Belum ada event yang tersedia saat ini. Pantau terus halaman ini untuk update event terbaru dari kami!
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">

                        @if($event->banner)
                            <img src="{{ asset('storage/' . $event->banner) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/400x200?text=QuickTick+Event" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $event->category->name ?? 'Umum' }}</span>
                            </div>

                            <h4 class="card-title fw-bold text-dark mt-2 mb-3">{{ $event->title }}</h4>

                            <p class="card-text text-muted mb-2 fs-6">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i> {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }} <br>
                                <i class="fas fa-clock me-2 text-primary"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB <br>
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> {{ $event->location }}
                            </p>

                            <p class="card-text text-danger mb-4 fw-bold">
                                <i class="fas fa-users me-2"></i> Kuota Tersedia: {{ $event->quota }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('user.event.show', $event->slug) }}" class="btn btn-primary w-100 rounded-pill fw-bold">
                                    <i class="fas fa-ticket-alt me-1"></i> Pesan Tiket / Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
