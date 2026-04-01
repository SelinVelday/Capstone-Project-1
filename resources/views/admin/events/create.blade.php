@extends('layouts.app')

@section('title', 'Tambah Event Baru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Form Tambah Event</div>
            </div>
            
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group @error('title') has-error @enderror">
                                <label for="title">Judul Event <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Masukkan nama acara" required>
                                @error('title') <small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group @error('description') has-error @enderror">
                                <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Ceritakan detail acara ini..." required>{{ old('description') }}</textarea>
                                @error('description') <small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="form-group @error('location') has-error @enderror">
                                <label for="location">Lokasi (Tempat) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Gelora Bung Karno, Jakarta" required>
                                @error('location') <small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group @error('date') has-error @enderror">
                                <label for="date">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                                @error('date') <small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group @error('start_time') has-error @enderror">
                                <label for="start_time">Waktu Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                @error('start_time') <small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group @error('quota') has-error @enderror">
                                <label for="quota">Total Kuota (Kapasitas) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quota" name="quota" value="{{ old('quota') }}" min="1" placeholder="Contoh: 1000" required>
                                @error('quota') <small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group @error('banner') has-error @enderror">
                                <label for="banner">Banner Gambar <span class="text-danger">*</span></label>
                                <input type="file" class="form-control-file" id="banner" name="banner" accept="image/*" required>
                                <small class="form-text text-muted">Format: JPG/PNG. Maks 2MB.</small>
                                @error('banner') <br><small class="form-text text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action text-end">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection