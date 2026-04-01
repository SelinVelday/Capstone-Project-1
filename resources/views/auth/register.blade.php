<x-guest-layout>
    @section('title', 'Daftar Akun - QuickTick')

    <div class="card card-round shadow-lg border-0 my-5">
        <div class="card-header text-center border-0 pt-4 pb-0">
            <h2 class="fw-bold mb-1"><i class="fas fa-ticket-alt text-primary me-2"></i>QuickTick</h2>
            <h5 class="text-muted">Buat Akun Baru</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group px-0 @error('name') has-error @enderror">
                    <label for="name" class="fw-bold">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group px-0 mt-2 @error('email') has-error @enderror">
                    <label for="email" class="fw-bold">Alamat Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Contoh: budi@gmail.com">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group px-0 mt-2 @error('password') has-error @enderror">
                    <label for="password" class="fw-bold">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Minimal 8 karakter">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group px-0 mt-2">
                    <label for="password_confirmation" class="fw-bold">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Ulangi password Anda">
                </div>

                <div class="form-group px-0 mt-4">
                    <button type="submit" class="btn btn-secondary btn-round w-100 fw-bold fs-6">Daftar Akun</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center border-0 pt-0 pb-4">
            <p class="mb-0 text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a></p>
        </div>
    </div>
</x-guest-layout>