@extends('layouts.app')

@section('title', 'Pembayaran Tiket')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h4 class="fw-bold mb-4 text-center">Selesaikan Pembayaran Anda</h4>

                <div class="alert alert-info shadow-sm mb-4">
                    <p class="mb-1">Total Tagihan:</p>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h2>
                    <p class="mt-2 mb-0 small">Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold">Instruksi Pembayaran</h5>
                    <p class="text-muted mb-2">Silakan transfer sesuai dengan total tagihan di atas ke rekening berikut:</p>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item px-0">
                            <strong>Bank BCA:</strong> 1234567890 a.n. PT QuickTick Indonesia
                        </li>
                        <li class="list-group-item px-0">
                            <strong>Bank Mandiri:</strong> 0987654321 a.n. PT QuickTick Indonesia
                        </li>
                    </ul>
                </div>

                <form action="{{ route('user.payment.process', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="payment_receipt" class="form-label fw-bold">Upload Bukti Transfer</label>
                        <input class="form-control" type="file" id="payment_receipt" name="payment_receipt" accept="image/*" required>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">
                        <i class="fas fa-upload me-2"></i> Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
