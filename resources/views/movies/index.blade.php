@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 pt-16">
        
<!-- BANNER MOVIEHUB -->

<!-- BANNER MOVIEHUB -->
<div class="mh-hero">

    <div class="mh-hero-badge">
        🎬 MOVIEHUB CINEMA
    </div>

    <h1 class="mh-hero-title">
        KHÁM PHÁ THẾ GIỚI
        <span>ĐIỆN ẢNH ĐỈNH CAO</span>
    </h1>

    <p class="mh-hero-description">
        Thưởng thức những bộ phim hấp dẫn,
        cập nhật lịch chiếu mới nhất và
        đặt vé trực tuyến nhanh chóng.
        Lựa chọn vị trí ghế yêu thích
        và tận hưởng trải nghiệm điện ảnh
        cùng MovieHub.
    </p>


    <div style="
        display:flex;
        flex-wrap:wrap;
        gap:15px;
    ">

        <a href="{{ url('/cinema/movies') }}"
           style="
               background:#ff914d;
               color:#111827;
               padding:14px 25px;
               border-radius:8px;
               font-weight:bold;
               text-decoration:none;
               display:inline-block;
           ">
            Xem phim đang chiếu
        </a>

        @auth
        <a href="{{ url('/my-bookings') }}"
           style="
               background:#475569;
               color:white;
               padding:14px 25px;
               border-radius:8px;
               font-weight:bold;
               text-decoration:none;
               display:inline-block;
           ">
            Vé đã đặt của tôi
        </a>
        @endauth

    </div>

</div>
<!-- KET THUC BANNER MOVIEHUB -->

        <div class="popular-movies">
           <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">
    PHIM NỔI BẬT
</h2>
            <div class="mh-movie-grid
grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-8
">
                @foreach ($popularMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach

            </div>
        </div> <!-- end pouplar-movies -->

        <div class="now-playing-movies py-24">
            <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">PHIM ĐANG CHIẾU</h2>
            <div class="mh-movie-grid 
grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-8
">
                @foreach ($nowPlayingMovies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </div> <!-- end now-playing-movies -->
        

<!-- PHIM DANG CHIEU TAI MOVIEHUB -->

<div style="padding:40px 0 70px;">

    <h2 style="color:#ff914d;
               font-size:24px;
               font-weight:bold;
               margin-bottom:25px;">
        PHIM ĐANG CHIẾU TẠI MOVIEHUB
    </h2>

    <div style="display:grid;
                grid-template-columns:repeat(auto-fill, minmax(230px, 1fr));
                gap:25px;">

        @forelse(($cinemaMovies ?? collect()) as $cinemaMovie)

        <div style="background:#2d3748;
                    border-radius:12px;
                    overflow:hidden;
                    max-width:290px;
                    display:flex;
                    flex-direction:column;">

            @if($cinemaMovie->poster)

            <a href="{{ url('/cinema/movies/' . $cinemaMovie->id) }}">

                <img src="{{ $cinemaMovie->poster }}"
                     alt="{{ $cinemaMovie->title }}"
                     style="width:100%;
                            height:380px;
                            object-fit:cover;
                            display:block;">

            </a>

            @else

            <div style="height:380px;
                        background:#475569;
                        display:flex;
                        align-items:center;
                        justify-content:center;">
                Chưa có poster
            </div>

            @endif

            <div style="padding:20px;
                        display:flex;
                        flex-direction:column;
                        gap:12px;
                        flex:1;">

                <h3 style="color:#ff914d;
                           font-size:20px;
                           font-weight:bold;
                           line-height:1.4;
                           margin:0;">
                    {{ $cinemaMovie->title }}
                </h3>

                <p style="color:#cbd5e1;
                          font-size:14px;
                          line-height:1.6;
                          margin:0;">
                    Thể loại:
                    {{ $cinemaMovie->genre ?: 'Đang cập nhật' }}
                </p>

                <p style="color:#cbd5e1;
                          font-size:14px;
                          margin:0;">
                    Thời lượng:
                    {{ $cinemaMovie->duration ? $cinemaMovie->duration . ' phút' : 'Đang cập nhật' }}
                </p>

                <a href="{{ url('/cinema/movies/' . $cinemaMovie->id) }}"
                   style="display:block;
                          background:#ff914d;
                          color:#111827;
                          text-align:center;
                          padding:12px 10px;
                          border-radius:8px;
                          font-weight:bold;
                          text-decoration:none;
                          margin-top:auto;">

                    Xem chi tiết - Đặt vé

                </a>

            </div>

        </div>

        @empty

        <p style="color:#cbd5e1;">
            Chưa có phim đang chiếu tại MovieHub.
        </p>

        @endforelse

    </div>

</div>

<!-- KET THUC PHIM MOVIEHUB -->

    </div>
@endsection
