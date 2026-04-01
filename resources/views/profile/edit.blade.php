@extends('layouts.app')

@section('title', 'Pengaturan Profil')

@section('content')
<div class="row">
    <div class="col-md-8">
        
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informasi Profil</div>
                <div class="card-category">Perbarui nama akun dan alamat email Anda.</div>
            </div>
            
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="form-group @error('name') has-error @enderror">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name') <small class="form-text text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group @error('email') has-error @enderror">
                        <label for="email">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email') <small class="form-text text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    @if (session('status') === 'profile-updated')
                        <span class="text-success ms-3 fw-bold"><i class="fas fa-check-circle"></i> Berhasil disimpan.</span>
                    @endif
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Ubah Password</div>
                <div class="card-category">Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.</div>
            </div>
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="card-body">
                    <div class="form-group @error('current_password', 'updatePassword') has-error @enderror">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
                        @error('current_password', 'updatePassword') <small class="form-text text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group @error('password', 'updatePassword') has-error @enderror">
                        <label for="password">Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                        @error('password', 'updatePassword') <small class="form-text text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group @error('password_confirmation', 'updatePassword') has-error @enderror">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword') <small class="form-text text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-secondary">Simpan Password</button>
                    @if (session('status') === 'password-updated')
                        <span class="text-success ms-3 fw-bold"><i class="fas fa-check-circle"></i> Password diperbarui.</span>
                    @endif
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title text-danger">Hapus Akun</div>
                <div class="card-category">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                    Hapus Akun Secara Permanen
                </button>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin ingin menghapus akun ini?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.</p>
                    <div class="form-group @error('password', 'userDeletion') has-error @enderror">
                        <label for="delete_password">Password</label>
                        <input type="password" class="form-control" id="delete_password" name="password" placeholder="Password Anda">
                        @error('password', 'userDeletion') <small class="form-text text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection