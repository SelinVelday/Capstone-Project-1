<div class="sidebar sidebar-style-2" data-background-color="white">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Utama</h4>
                </li>

                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard Utama</p>
                    </a>
                </li>

                @if(auth()->user()->role === 'admin')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Panel Admin</h4>
                    </li>

                    <li class="nav-item {{ Request::is('admin/events*') ? 'active' : '' }}">
                        <a href="{{ route('admin.events.index') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Kelola Event</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('admin/bookings*') ? 'active' : '' }}">
                        <a href="{{ route('admin.bookings.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Kelola Pesanan</p>
                            @php
                                $pendingCount = \App\Models\Booking::where('payment_status', 'unpaid')->whereNotNull('payment_receipt')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge badge-danger">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                @endif

                @if(auth()->user()->role === 'user')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Pemesanan Saya</h4>
                    </li>

                    <li class="nav-item {{ Request::is('user/dashboard') || Request::is('user/events*') ? 'active' : '' }}">
                        <a href="{{ route('user.dashboard') }}">
                            <i class="fas fa-th-large"></i>
                            <p>Katalog Event</p>
                        </a>
                    </li>

                    <li class="nav-item {{ Request::is('user/my-tickets*') || Request::is('user/payment*') ? 'active' : '' }}">
                        <a href="{{ route('user.tickets.index') }}">
                            <i class="fas fa-ticket-alt"></i>
                            <p>Tiket Saya</p>
                        </a>
                    </li>
                @endif

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Akun</h4>
                </li>

                <li class="nav-item {{ Request::is('profile*') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-cog"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                        <i class="fas fa-sign-out-alt text-danger"></i>
                        <p>Keluar</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
