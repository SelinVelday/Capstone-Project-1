@extends('layouts.app')

@section('title', 'Kelola Event')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Daftar Event</h4>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-round">
                    <i class="fas fa-plus"></i> Tambah Event Baru
                </a>
            </div>
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-head-bg-primary">
                        <thead>
                            <tr>
                                <th>Banner</th>
                                <th>Judul Event</th>
                                <th>Tanggal & Waktu</th>
                                <th>Lokasi</th>
                                <th>Kuota</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="banner" class="img-thumbnail" width="80">
                                </td>
                                <td><strong>{{ $event->title }}</strong></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} <br>
                                    <small class="text-muted">{{ $event->start_time }} WIB</small>
                                </td>
                                <td>{{ $event->location }}</td>
                                <td>{{ $event->quota }}</td>
                                <td>
                                    <span class="badge badge-{{ $event->status == 'active' ? 'success' : 'danger' }}">
                                        {{ strtoupper($event->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.events.tickets.index', $event->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Kelola Tiket">
                                        <i class="fas fa-ticket-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada event. Silakan tambah event baru.</td>
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