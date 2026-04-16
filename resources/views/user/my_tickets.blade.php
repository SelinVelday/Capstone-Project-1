@extends('layouts.app')

@section('title', 'Tiket Saya')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Riwayat Pemesanan Tiket</h4>
            </div>

            @if(session('success'))
                <div class="alert alert-success shadow-sm mb-4">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Kode Booking</th>
                                <th class="py-3">Nama Event</th>
                                <th class="py-3">Tanggal Pelaksanaan</th>
                                <th class="py-3 text-center">Jumlah Tiket</th>
                                <th class="px-4 py-3 text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-primary">{{ $booking->booking_code }}</td>
                                    <td class="py-3 fw-semibold">{{ $booking->event->title }}</td>
                                    <td class="py-3">{{ \Carbon\Carbon::parse($booking->event->date)->translatedFormat('d F Y') }}</td>
                                    <td class="py-3 text-center">{{ $booking->quantity }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge bg-success rounded-pill px-3 py-2">Berhasil</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-ticket-alt fa-3x mb-3 text-light"></i>
                                        <br> Anda belum memiliki tiket. <br>
                                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary mt-3 rounded-pill">Cari Event Sekarang</a>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
