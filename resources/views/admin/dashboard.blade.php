
@extends('layouts.main')

@section('content')

<style>
    .admin-dashboard {
        max-width: 1100px;
        margin: 0 auto;
        padding: 45px 20px 80px;
        min-height: 500px;
    }

    .admin-title {
        color: white;
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .admin-welcome {
        color: #cbd5e1;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .admin-card {
        background: #2d3748;
        border-radius: 12px;
        padding: 24px;
        min-height: 175px;
        transition: transform 0.2s, background 0.2s;
    }

    .admin-card:hover {
        transform: translateY(-4px);
        background: #374151;
    }

    .admin-icon {
        width: 30px;
        height: 30px;
        color: #ff914d;
        margin-bottom: 14px;
    }

    .admin-card h2 {
        color: #ff914d;
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .admin-card p {
        color: #cbd5e1;
        font-size: 14px;
        line-height: 1.6;
    }

    @media (max-width: 850px) {
        .admin-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-dashboard">

    <h1 class="admin-title">
        TRANG QUẢN TRỊ MOVIEHUB
    </h1>

    <p class="admin-welcome">
        Xin chào, {{ auth()->user()->name }}!
    </p>

<!-- THỐNG KÊ TỔNG QUAN MOVIEHUB -->

<style>
    .moviehub-stats {
        margin-top: 35px;
        margin-bottom: 40px;
    }

    .moviehub-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-top: 20px;
    }

    .moviehub-stat-card {
        background: #2d3748;
        border-radius: 12px;
        padding: 25px;
        min-width: 0;
    }

    .moviehub-stat-label {
        color: #ff914d;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .moviehub-stat-number {
        color: white;
        font-size: 32px;
        font-weight: bold;
    }

    .moviehub-revenue-card {
        background: #2d3748;
        padding: 25px;
        border-radius: 12px;
        margin-top: 20px;
    }

    @media (max-width: 900px) {
        .moviehub-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 500px) {
        .moviehub-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="moviehub-stats">

    <h2 style="font-size:25px;
               font-weight:bold;
               margin-bottom:10px;">
        THỐNG KÊ TỔNG QUAN
    </h2>

    <p style="color:#cbd5e1;">
        Theo dõi tình hình hoạt động của hệ thống MovieHub.
    </p>

    <div class="moviehub-stats-grid">

        <div class="moviehub-stat-card">
            <div class="moviehub-stat-label">
                Tổng số phim
            </div>
            <div class="moviehub-stat-number">
                {{ $movieCount }}
            </div>
        </div>

        <div class="moviehub-stat-card">
            <div class="moviehub-stat-label">
                Tổng suất chiếu
            </div>
            <div class="moviehub-stat-number">
                {{ $showtimeCount }}
            </div>
        </div>

        <div class="moviehub-stat-card">
            <div class="moviehub-stat-label">
                Tổng đơn đặt vé
            </div>
            <div class="moviehub-stat-number">
                {{ $bookingCount }}
            </div>
        </div>

        <div class="moviehub-stat-card">
            <div class="moviehub-stat-label">
                Đơn đã xác nhận
            </div>
            <div class="moviehub-stat-number">
                {{ $confirmedCount }}
            </div>
        </div>

    </div>

    <div class="moviehub-stats-grid">

        <div class="moviehub-stat-card">
            <div class="moviehub-stat-label">
                Đơn chờ xác nhận
            </div>
            <div class="moviehub-stat-number">
                {{ $pendingCount }}
            </div>
        </div>

        <div class="moviehub-stat-card">
            <div class="moviehub-stat-label">
                Đơn đã hủy
            </div>
            <div class="moviehub-stat-number">
                {{ $cancelledCount }}
            </div>
        </div>

        <div class="moviehub-stat-card"
             style="grid-column:span 2;">
            <div class="moviehub-stat-label">
                Giá trị đơn đã xác nhận
            </div>

            <div class="moviehub-stat-number"
                 style="color:#ff914d;">
                {{ number_format($confirmedBookingValue, 0, ',', '.') }} đ
            </div>

            <p style="color:#cbd5e1;
                      font-size:13px;
                      margin-top:10px;">
                Chưa bao gồm xác minh thanh toán.
            </p>
        </div>

    </div>

</div>

<!-- KẾT THÚC THỐNG KÊ -->

    <div class="admin-grid">

        <!-- QUẢN LÝ PHIM -->
        <div class="admin-card">
            <svg class="admin-icon" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <rect x="2" y="7" width="20"
                      height="14" rx="2"/>
                <path d="M2 7l2-5h16l2 5"/>
                <path d="M7 2l3 5M14 2l3 5"/>
            </svg>

            <h2>Quản lý phim</h2>
            <p>Thêm, sửa, xóa và cập nhật phim.</p>
            
            <a href="{{ route('admin.movies.index') }}"
            style="display:inline-block;
                    background:#ff914d;
                    color:#111827;
                    padding:10px 18px;
                    border-radius:8px;
                    margin-top:20px;
                    font-weight:bold;
                    text-decoration:none;">
                Mở quản lý phim →
            </a>

        </div>

        <!-- QUẢN LÝ SUẤT CHIẾU -->
        <div class="admin-card">
            <svg class="admin-icon" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <rect x="3" y="5" width="18"
                      height="16" rx="2"/>
                <path d="M16 3v4M8 3v4M3 10h18"/>
                <path d="M8 14h2M14 14h2M8 18h2"/>
            </svg>

            <h2>Quản lý suất chiếu</h2>
            <p>Thêm và quản lý lịch chiếu phim.</p>
            
            <a href="{{ route('admin.showtimes.index') }}"
            style="display:inline-block;
                    background:#ff914d;
                    color:#111827;
                    padding:10px 18px;
                    border-radius:8px;
                    margin-top:20px;
                    font-weight:bold;
                    text-decoration:none;">
                Mở quản lý suất chiếu →
            </a>

        </div>

        <!-- QUẢN LÝ ĐẶT VÉ -->
        <div class="admin-card">
            <svg class="admin-icon" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M2 9V5a2 2 0 0 1 2-2h16
                         a2 2 0 0 1 2 2v4
                         a3 3 0 0 0 0 6v4
                         a2 2 0 0 1-2 2H4
                         a2 2 0 0 1-2-2v-4
                         a3 3 0 0 0 0-6Z"/>
                <path d="M13 5v2M13 10v4M13 17v2"/>
            </svg>

            <h2>Quản lý đặt vé</h2>
            <p>Xem và quản lý các vé đã đặt.</p>
            
            <a href="{{ route('admin.bookings.index') }}"
            style="display:inline-block;
                    background:#ff914d;
                    color:#111827;
                    padding:10px 18px;
                    border-radius:8px;
                    margin-top:20px;
                    font-weight:bold;
                    text-decoration:none;">
                Mở quản lý đặt vé →
            </a>

        </div>

    </div>
</div>

@endsection
