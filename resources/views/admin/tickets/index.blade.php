@extends('layouts.app')

@section('title', 'Kelola Tiket - ' . $event->title)

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Manajemen Tiket: <span class="text-primary">{{ $event->title }}</span></h4>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali ke Event
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tambah Jenis Tiket</div>
            </div>
            <form action="{{ route('admin.events.tickets.store', $event->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Tiket <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Misal: VIP, Regular, Early Bird" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Misal: 150000 (Isi 0 jika gratis)" min="0" required>
                        @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="quota">Kuota/Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('quota') is-invalid @enderror" id="quota" name="quota" placeholder="Misal: 100" min="1" required>
                        @error('quota') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success w-100">Simpan Tiket</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Daftar Tiket Tersedia</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
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
                                <td>{{ $ticket->quota }} Lembar</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.events.tickets.destroy', [$event->id, $ticket->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jenis tiket ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada jenis tiket untuk event ini. Silakan tambahkan di form sebelah kiri.</td>
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