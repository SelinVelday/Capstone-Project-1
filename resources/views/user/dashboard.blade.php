@extends('layouts.app')

@section('title', 'Katalog Event')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Selamat Datang di QuickTick</p>
                            <h4 class="card-title">Temukan Event Menarik Untukmu!</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-primary shadow-sm" role="alert">
            <i class="fas fa-info-circle me-2"></i> Belum ada event yang tersedia saat ini. Pantau terus halaman ini untuk update event terbaru dari kami!
        </div>
    </div>
</div>
@endsection