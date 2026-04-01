@extends('layouts.app')

@section('title', 'Kelola Tiket - ' . $event->title)

@section('content')
<div class="page-header">
    <h4 class="page-title">Kelola Tiket: {{ $event->title }}</h4>
    <div class="ms-auto">
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-round"><i class="fas fa-arrow-left me-2"></i> Kembali ke Event</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card card-round shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-white mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Jenis Tiket</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.events.tickets.store', $event->id) }}" method="POST">
                    @csrf
                    <div class="form-group px-0">
                        <label for="name" class="fw-bold">Nama Tiket</label>
                        <input type="text" class="form-control" name="name" placeholder="Contoh: VIP, Festival" required>
                    </div>
                    <div class="form-group px-0">
                        <label for="price" class="fw-bold">Harga Tiket (Rp)</label>
                        <input type="number" class="form-control" name="price" placeholder="Contoh: 150000 (0 untuk Gratis)" required min="0">
                    </div>
                    <div class="form-group px-0">
                        <label for="quota" class="fw-bold">Kuota Tiket</label>
                        <input type="number" class="form-control" name="quota" placeholder="Contoh: 100" required min="1">
                    </div>
                    <button type="submit" class="btn btn-primary btn-round w-100 mt-3">Simpan Tiket</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-round shadow-sm">
            <div class="card-header">
                <h4 class="card-title mb-0">Daftar Jenis Tiket</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Tiket</th>
                                <th>Harga</th>
                                <th>Kuota</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td><strong>{{ $ticket->name }}</strong></td>
                                <td>Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                                <td>{{ $ticket->quota }} lembar</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-round"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">Belum ada jenis tiket untuk event ini.</td>
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