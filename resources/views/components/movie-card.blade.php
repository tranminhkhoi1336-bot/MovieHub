
<div class="mh-movie-card">

    <!-- Poster phim -->
    <a href="{{ route('movies.show', $movie['id']) }}"
       class="mh-movie-poster">
@php
    $poster = !empty($movie['poster_path'])
        ? $movie['poster_path']
        : ($movie['poster'] ?? '');

    if (!empty($poster)) {
        $host = parse_url($poster, PHP_URL_HOST);
        $port = parse_url($poster, PHP_URL_PORT);
        $path = parse_url($poster, PHP_URL_PATH);

        // Chuyển đường dẫn ảnh cũ từ cổng 8000
        // sang đường dẫn tương đối của website hiện tại
        if (
            in_array($host, ['127.0.0.1', 'localhost'])
            && (int) $port === 8000
            && $path
        ) {
            $poster = $path;
        } elseif (strpos($poster, 'uploads/posters/') === 0) {
            $poster = '/' . $poster;
        }
    }
@endphp

<img src="{{ $poster }}"
     alt="Poster phim {{ $movie['title'] }}"
     loading="lazy">

        <span class="mh-movie-overlay">
            Xem chi tiết phim
        </span>
    </a>

    <!-- Thong tin phim -->
    <div class="mh-movie-body">

        <a href="{{ route('movies.show', $movie['id']) }}"
           class="mh-movie-title">
            {{ $movie['title'] }}
        </a>

        <div class="mh-movie-details">

            
@php
    $rating = isset($movie['vote_average'])
        ? (float) $movie['vote_average']
        : null;

    if ($rating !== null && $rating > 10) {
        $rating = $rating / 10;
    }
@endphp

@if($rating !== null && $rating > 0)
    <span class="mh-movie-rating">
        &#9733; {{ number_format($rating, 1) }}/10
    </span>
@else
    <span class="mh-movie-date">
        Chưa có đánh giá
    </span>
@endif


            @if(!empty($movie['release_date']))
                <span class="mh-movie-date">
                    {{ $movie['release_date'] }}
                </span>
            @endif

        </div>

        @if(!empty($movie['genres']))
            <p class="mh-movie-genres">
                {{ $movie['genres'] }}
            </p>
        @endif

        <a href="{{ route('movies.show', $movie['id']) }}"
           class="mh-movie-button">
            Xem chi tiết
            <span aria-hidden="true">&rarr;</span>
        </a>

    </div>

</div>
