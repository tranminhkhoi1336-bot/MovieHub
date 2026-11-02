
@extends('layouts.main')

@section('content')

<style>
    .cinema-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
        min-height: 500px;
    }

    .cinema-title {
        color: white;
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .cinema-heading {
        color: #ff914d;
        font-size: 24px;
        font-weight: bold;
        margin: 35px 0 20px;
    }

    .cinema-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
    }

    .cinema-card {
        background: #2d3748;
        border-radius: 12px;
        overflow: hidden;
        min-width: 0;
    }

    .cinema-poster {
        width: 100%;
        height: 310px;
        object-fit: cover;
        display: block;
    }

    .cinema-no-poster {
        height: 310px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #475569;
        color: white;
    }

    .cinema-info {
        padding: 20px;
    }

    .cinema-name {
        color: #ff914d;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .cinema-detail {
        color: #cbd5e1;
        margin-bottom: 8px;
    }

    .cinema-empty {
        color: #cbd5e1;
        padding: 25px;
        background: #2d3748;
        border-radius: 10px;
    }

    @media (max-width: 900px) {
        .cinema-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 500px) {
        .cinema-grid {
            grid-template-columns: 1fr;
        }
    }
    
/* MOVIEHUB - CAN DEU NUT XEM CHI TIET */

/* Khung danh sach phim */
.cinema-grid {
    align-items: stretch !important;
}

/* Cac the phim co chieu cao bang nhau */
.cinema-grid .cinema-card {
    display: flex !important;
    flex-direction: column !important;
    height: 100% !important;
    box-sizing: border-box !important;
}

/* Noi dung ben trong the phim */
.cinema-grid .cinema-info {
    display: flex !important;
    flex-direction: column !important;
    flex: 1 1 auto !important;
}

/* Day nut Xem chi tiet xuong cuoi */
.cinema-grid .cinema-info > a {
    margin-top: auto !important;
    align-self: flex-start !important;
}

</style>

<div class="cinema-container">

    <h1 class="cinema-title">
        DANH SÁCH PHIM MOVIEHUB
    </h1>

    <p style="color:#cbd5e1;">
        Khám phá các bộ phim đang chiếu và sắp chiếu.
    </p>

    <h2 class="cinema-heading">
        PHIM ĐANG CHIẾU
    </h2>

    <div class="cinema-grid">

        @forelse($nowShowing as $movie)

            <div class="cinema-card">

                @if($movie->poster)
                    <img
                        src="{{ $movie->poster }}"
                        alt="{{ $movie->title }}"
                        class="cinema-poster">
                @else
                    <div class="cinema-no-poster">
                        Chưa có poster
                    </div>
                @endif

                <div class="cinema-info">

                    <h3 class="cinema-name">
                        {{ $movie->title }}
                    </h3>

                    <p class="cinema-detail">
                        Thể loại:
                        {{ $movie->genre ?: 'Đang cập nhật' }}
                    </p>

                    <p class="cinema-detail">
                        Thời lượng:
                        {{ $movie->duration ?: 'Đang cập nhật' }}
                        @if($movie->duration) phút @endif
                    </p>

                    <p class="cinema-detail">
                        {{ \Illuminate\Support\Str::limit($movie->description, 120) }}
                    </p>

                    <a href="{{ route('cinema.movies.show', $movie->id) }}"
                    style="display:inline-block;
                            background:#ff914d;
                            color:#111827;
                            padding:12px 20px;
                            border-radius:8px;
                            text-decoration:none;
                            font-weight:bold;
                            margin-top:15px;">
                        Xem chi tiết →
                    </a>

                </div>
            </div>

        @empty

            <p class="cinema-empty">
                Hiện chưa có phim đang chiếu.
            </p>

        @endforelse

    </div>

    <h2 class="cinema-heading">
        PHIM SẮP CHIẾU
    </h2>

    <div class="cinema-grid">

        @forelse($comingSoon as $movie)

            <div class="cinema-card">

                @if($movie->poster)
                    <img
                        src="{{ $movie->poster }}"
                        alt="{{ $movie->title }}"
                        class="cinema-poster">
                @else
                    <div class="cinema-no-poster">
                        Chưa có poster
                    </div>
                @endif

                <div class="cinema-info">

                    <h3 class="cinema-name">
                        {{ $movie->title }}
                    </h3>

                    <p class="cinema-detail">
                        Thể loại:
                        {{ $movie->genre ?: 'Đang cập nhật' }}
                    </p>

                    <p class="cinema-detail">
                        Thời lượng:
                        {{ $movie->duration ?: 'Đang cập nhật' }}
                        @if($movie->duration) phút @endif
                    </p>

                    <p class="cinema-detail">
                        {{ \Illuminate\Support\Str::limit($movie->description, 120) }}
                    </p>

                    <a href="{{ route('cinema.movies.show', $movie->id) }}"
                    style="display:inline-block;
                            background:#ff914d;
                            color:#111827;
                            padding:12px 20px;
                            border-radius:8px;
                            text-decoration:none;
                            font-weight:bold;
                            margin-top:15px;">
                        Xem chi tiết →
                    </a>

                </div>
            </div>

        @empty

            <p class="cinema-empty">
                Hiện chưa có phim sắp chiếu.
            </p>

        @endforelse

    </div>

</div>

@endsection
