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

                        {{-- Pesan Error Global --}}
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm">
                                <h5 class="alert-heading fw-bold mb-1"><i class="fas fa-exclamation-triangle"></i> Oops! Ada yang terlewat:</h5>
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row mt-3">
                            {{-- Sisi Kiri --}}
                            <div class="col-md-8">
                                <div class="form-group @error('title') has-error @enderror">
                                    <label for="title">Judul Event <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Masukkan nama acara" required>
                                    @error('title') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Dropdown Kategori & Fitur Kategori Baru --}}
                                <div class="form-group @error('category_id') has-error @enderror">
                                    <label for="category_id">Kategori Event <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category_id" name="category_id" required onchange="toggleNewCategory()">
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                        <option value="lainnya" {{ old('category_id') == 'lainnya' ? 'selected' : '' }}>+ Lainnya (Isi Sendiri)</option>
                                    </select>
                                    @error('category_id') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                {{-- Input Text ini tersembunyi, muncul jika pilih 'Lainnya' --}}
                                <div class="form-group @error('new_category_name') has-error @enderror" id="new_category_group" style="display: {{ old('category_id') == 'lainnya' ? 'block' : 'none' }};">
                                    <label for="new_category_name" class="text-primary">Nama Kategori Baru <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="new_category_name" name="new_category_name" value="{{ old('new_category_name') }}" placeholder="Contoh: Webinar, Workshop, Musik">
                                    @error('new_category_name') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group @error('description') has-error @enderror">
                                    <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Ceritakan detail acara ini..." required>{{ old('description') }}</textarea>
                                    @error('description') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group @error('location') has-error @enderror">
                                    <label for="location">Lokasi (Tempat) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Jakarta, Online via Zoom" required>
                                    @error('location') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            {{-- Sisi Kanan --}}
                            <div class="col-md-4">
                                <div class="form-group @error('status') has-error @enderror">
                                    <label for="status">Status Event <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Tayangkan)</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Simpan Saja)</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive (Non-aktif)</option>
                                    </select>
                                    @error('status') <small class="form-text text-danger">{{ $message }}</small> @enderror
                                </div>

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
                                    <label for="quota">Total Kuota <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="quota" name="quota" value="{{ old('quota') }}" min="1" placeholder="Contoh: 100" required>
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
                        <button type="submit" class="btn btn-success">Simpan Event Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleNewCategory() {
            var categorySelect = document.getElementById('category_id');
            var newCategoryGroup = document.getElementById('new_category_group');
            var newCategoryInput = document.getElementById('new_category_name');

            if (categorySelect.value === 'lainnya') {
                newCategoryGroup.style.display = 'block';
                newCategoryInput.setAttribute('required', 'required');
                newCategoryInput.focus();
            } else {
                newCategoryGroup.style.display = 'none';
                newCategoryInput.removeAttribute('required');
            }
        }
    </script>
@endsection
