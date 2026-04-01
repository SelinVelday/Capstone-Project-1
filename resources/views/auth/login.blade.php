<x-guest-layout>
    @section('title', 'Login - QuickTick')

    <div class="card card-round shadow-lg border-0 mt-5">
        <div class="card-header text-center border-0 pt-4 pb-0">
            <h2 class="fw-bold mb-1"><i class="fas fa-ticket-alt text-primary me-2"></i>QuickTick</h2>
            <h5 class="text-muted">Masuk ke Akun Anda</h5>
        </div>
        <div class="card-body p-4">
            <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group px-0 @error('email') has-error @enderror">
                    <label for="email" class="fw-bold">Alamat Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email Anda">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group px-0 mt-2 @error('password') has-error @enderror">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="fw-bold mb-0">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small">Lupa Password?</a>
                        @endif
                    </div>
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Masukkan password Anda">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-check px-0 mt-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>

                <div class="form-group px-0 mt-4">
                    <button type="submit" class="btn btn-primary btn-round w-100 fw-bold fs-6">Masuk Sekarang</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center border-0 pt-0 pb-4">
            <p class="mb-0 text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar di sini</a></p>
        </div>
    </div>
</x-guest-layout>