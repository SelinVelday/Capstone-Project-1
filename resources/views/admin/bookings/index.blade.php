@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4 class="fw-bold mb-4">Daftar Semua Pesanan</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">User</th>
                                <th class="py-3">Event</th>
                                <th class="py-3">Total Bayar</th>
                                <th class="py-3">Bukti</th>
                                <th class="py-3 text-center">Status Bayar</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-4 py-3">{{ $booking->user->name }}</td>
                                    <td class="py-3 text-truncate" style="max-width: 150px;">{{ $booking->event->title }}</td>
                                    <td class="py-3 fw-bold text-success">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    <td class="py-3">
                                        @if($booking->payment_receipt)
                                            <a href="{{ asset('storage/' . $booking->payment_receipt) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-eye"></i> Lihat Bukti
                                            </a>
                                        @else
                                            <span class="text-muted small">Belum upload</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($booking->payment_status == 'paid')
                                            <span class="badge bg-success rounded-pill">Lunas</span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($booking->payment_status == 'unpaid' && $booking->payment_receipt)
                                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Konfirmasi</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
