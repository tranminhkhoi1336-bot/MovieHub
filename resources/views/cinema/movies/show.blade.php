
@extends('layouts.main')

@section('content')

<style>
/* TRANG CHI TIET PHIM */
.mh-detail-page {
    max-width: 1240px;
    margin: 0 auto;
    padding: 36px 20px 90px;
    color: #fff;
}

.mh-detail-back {
    display: inline-block;
    margin-bottom: 24px;
    color: #ff914d;
    text-decoration: none;
    font-weight: 600;
}

.mh-detail-back:hover {
    color: #ffba8d;
}

/* KHUNG THONG TIN PHIM */
.mh-detail-hero {
    position: relative;
    overflow: hidden;
    display: grid;
    grid-template-columns: 260px minmax(0, 1fr);
    gap: 38px;
    padding: 38px;
    border: 1px solid #40506a;
    border-radius: 24px;
    background: linear-gradient(120deg, #29374d, #141e30);
    box-shadow: 0 20px 55px rgba(0,0,0,.22);
}

.mh-detail-backdrop {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: .20;
    filter: blur(35px);
    transform: scale(1.12);
    pointer-events: none;
}

.mh-detail-hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(
        110deg,
        rgba(15,23,42,.65),
        rgba(15,23,42,.90)
    );
}

.mh-detail-poster-wrap,
.mh-detail-info {
    position: relative;
    z-index: 1;
}

.mh-detail-poster {
    width: 100%;
    aspect-ratio: 2 / 3;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,.4);
}

.mh-detail-placeholder {
    aspect-ratio: 2 / 3;
    border-radius: 15px;
    background: #35445b;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #cbd5e1;
}

.mh-detail-label {
    display: inline-block;
    color: #ff914d;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 2px;
    margin-bottom: 12px;
}

.mh-detail-title {
    color: #fff;
    font-size: clamp(28px, 3vw, 43px);
    line-height: 1.2;
    font-weight: 900;
    margin-bottom: 22px;
}

.mh-detail-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 22px;
}

.mh-detail-tag {
    padding: 9px 14px;
    border-radius: 8px;
    background: rgba(255,255,255,.09);
    border: 1px solid rgba(255,255,255,.13);
    color: #e2e8f0;
    font-size: 13px;
}

.mh-detail-status {
    margin-bottom: 24px;
    font-weight: 700;
}

.mh-detail-status.active {
    color: #4ade80;
}

.mh-detail-status.upcoming {
    color: #ffb454;
}

.mh-detail-subtitle {
    font-size: 19px;
    font-weight: 800;
    color: #ff914d;
    margin-bottom: 12px;
}

.mh-detail-description {
    color: #cbd5e1;
    line-height: 1.9;
    font-size: 16px;
    white-space: pre-line;
    margin-bottom: 26px;
}

.mh-detail-jump {
    display: inline-block;
    background: #ff914d;
    color: #111827;
    padding: 13px 24px;
    border-radius: 10px;
    font-weight: 800;
    text-decoration: none;
}

.mh-detail-jump:hover {
    background: #ffad79;
}

/* LICH CHIEU */
.mh-showtimes {
    margin-top: 54px;
    scroll-margin-top: 110px;
}

.mh-section-title {
    font-size: 27px;
    font-weight: 900;
    color: white;
    padding-left: 16px;
    border-left: 5px solid #ff914d;
    margin-bottom: 10px;
}

.mh-section-description {
    color: #94a3b8;
    margin-bottom: 26px;
    line-height: 1.7;
}

.mh-showtimes-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.mh-showtime-card {
    background: #29364b;
    border: 1px solid #40506a;
    border-radius: 17px;
    padding: 25px;
    transition: border-color .2s, transform .2s;
}

.mh-showtime-card:hover {
    border-color: #ff914d;
    transform: translateY(-3px);
}

.mh-showtime-caption {
    color: #ff914d;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1px;
}

.mh-showtime-date {
    font-size: 23px;
    font-weight: 800;
    margin: 12px 0 6px;
    color: #fff;
}

.mh-showtime-time {
    color: #cbd5e1;
    margin-bottom: 20px;
}

.mh-showtime-details {
    border-top: 1px solid #43516a;
    padding-top: 16px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 23px;
}

.mh-showtime-price {
    color: #ff914d;
    font-size: 21px;
    font-weight: 800;
}

.mh-showtime-seats {
    color: #cbd5e1;
}

.mh-showtime-button,
.mh-showtime-disabled {
    display: block;
    width: 100%;
    padding: 14px 18px;
    text-align: center;
    border-radius: 10px;
    font-weight: 800;
    text-decoration: none;
}

.mh-showtime-button {
    background: #ff914d;
    color: #111827;
}

.mh-showtime-button:hover {
    background: #ffb17f;
}

.mh-showtime-disabled {
    background: #455266;
    color: #cbd5e1;
    cursor: not-allowed;
}

.mh-showtime-unavailable {
    background: #672c35;
    color: #fff;
}

.mh-no-showtimes {
    grid-column: 1 / -1;
    padding: 35px;
    border-radius: 15px;
    text-align: center;
    background: #29364b;
    color: #cbd5e1;
}

/* DIEN THOAI */
@media (max-width: 850px) {
    .mh-detail-hero {
        grid-template-columns: 210px minmax(0,1fr);
        gap: 24px;
        padding: 25px;
    }
}

@media (max-width: 650px) {
    .mh-detail-hero {
        grid-template-columns: 1fr;
        padding: 22px;
    }

    .mh-detail-poster-wrap {
        max-width: 250px;
        margin: 0 auto;
    }

    .mh-showtimes-grid {
        grid-template-columns: 1fr;
    }

    .mh-showtime-date {
        font-size: 21px;
    }
}
</style>

<main class="mh-detail-page">

    <a href="{{ route('cinema.movies.index') }}"
       class="mh-detail-back">
        ← Quay lại danh sách phim
    </a>

    <!-- THONG TIN PHIM -->
    <section class="mh-detail-hero">

        @if($movie->poster)
            <img src="{{ $movie->poster }}"
                 class="mh-detail-backdrop"
                 alt=""
                 aria-hidden="true">
        @endif

        <div class="mh-detail-poster-wrap">
            @if($movie->poster)
                <img src="{{ $movie->poster }}"
                    class="mh-detail-poster mh-mobile-detail-poster"
                     alt="Poster {{ $movie->title }}">
            @else
                <div class="mh-detail-placeholder">
                    Chưa có poster
                </div>
            @endif
        </div>

        <div class="mh-detail-info">

            <span class="mh-detail-label">
                MOVIEHUB CINEMA
            </span>

            <h1 class="mh-detail-title mh-mobile-detail-title">
    {{ $movie->title }}
</h1>

            <div class="mh-detail-tags">
                <span class="mh-detail-tag">
                    🎬 {{ $movie->genre ?: 'Đang cập nhật' }}
                </span>

                <span class="mh-detail-tag">
                    ⏱ {{ $movie->duration ? $movie->duration . ' phút' : 'Đang cập nhật' }}
                </span>

                <span class="mh-detail-tag">
                    📅 {{ $movie->release_date ?: 'Đang cập nhật' }}
                </span>
            </div>

            @if($movie->status == 'now_showing')
                <div class="mh-detail-status active">
                    ● ĐANG CHIẾU
                </div>
            @else
                <div class="mh-detail-status upcoming">
                    ● SẮP CHIẾU
                </div>
            @endif

            <h2 class="mh-detail-subtitle">
                NỘI DUNG PHIM
            </h2>

            <p class="mh-detail-description">{{ $movie->description ?: 'Chưa cập nhật mô tả phim.' }}</p>

            <a href="#mh-showtimes"
               class="mh-detail-jump">
                XEM LỊCH CHIẾU ↓
            </a>

        </div>
    </section>

    <!-- LICH CHIEU -->
    <section id="mh-showtimes" class="mh-showtimes">

        <h2 class="mh-section-title">
            LỊCH CHIẾU & ĐẶT VÉ
        </h2>

        <p class="mh-section-description">
            Lựa chọn suất chiếu phù hợp và đặt vị trí ghế
            yêu thích tại MovieHub.
        </p>

        <div class="mh-showtimes-grid">

            @forelse($showtimes as $showtime)

                <article class="mh-showtime-card">

                    <div class="mh-showtime-caption">
                        SUẤT CHIẾU #{{ $showtime->id }}
                    </div>

                    <div class="mh-showtime-date">
                        {{ $showtime->starts_at->format('d/m/Y') }}
                    </div>

                    <div class="mh-showtime-time">
                        🕒 {{ $showtime->starts_at->format('H:i') }}
                    </div>

                    <div class="mh-showtime-details">

                        <div>
                            <div class="mh-showtime-caption">
                                GIÁ VÉ
                            </div>
                            <div class="mh-showtime-price">
                                {{ number_format($showtime->price, 0, ',', '.') }} đ
                            </div>
                        </div>

                        <div>
                            <div class="mh-showtime-caption">
                                SỐ GHẾ
                            </div>
                            <div class="mh-showtime-seats">
                                {{ $showtime->total_seats }} ghế
                            </div>
                        </div>
                    </div>

                    @if(\Carbon\Carbon::parse($showtime->starts_at)->lessThanOrEqualTo(now()))

                        <span class="mh-showtime-disabled">
                            Suất chiếu đã bắt đầu
                        </span>

                    @elseif($showtime->status !== 'scheduled')

                        <span class="mh-showtime-disabled mh-showtime-unavailable">
                            Suất chiếu không nhận đặt vé
                        </span>

                    @else

                        <a href="{{ route('customer.bookings.create', ['showtime_id' => $showtime->id]) }}"
                           class="mh-showtime-button">
                            ĐẶT VÉ NGAY →
                        </a>

                    @endif

                </article>

            @empty

                <div class="mh-no-showtimes">
                    Hiện chưa có suất chiếu sắp tới
                    cho bộ phim này.
                </div>

            @endforelse

        </div>
    </section>

</main>

@endsection
