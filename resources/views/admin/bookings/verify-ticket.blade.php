
@extends('layouts.main')

@section('content')

<div style="max-width:750px; margin:50px auto; padding:20px;">

    <div style="background:#2d3748; padding:30px;
                border-radius:15px; color:white;">

        <h1 style="color:#ff914d; font-size:30px;">
            KIỂM TRA VÉ MOVIEHUB
        </h1>

        <hr style="border:1px solid #475569; margin:20px 0;">

        @if(session('success'))
            <p style="color:#4ade80;">
                {{ session('success') }}
            </p>
        @endif

        @if(session('error'))
            <p style="color:#f87171;">
                {{ session('error') }}
            </p>
        @endif

        <h2 style="color:#ff914d; font-size:24px;">
            {{ $booking->showtime->movie->title }}
        </h2>

        <p>Mã vé: #{{ $booking->id }}</p>

        <p>
            Suất chiếu:
            {{ $booking->showtime->starts_at->format('d/m/Y H:i') }}
        </p>

        <p>
            Ghế:
            {{ implode(', ', $booking->seat_codes ?? []) }}
        </p>

        <p>Số lượng vé: {{ $booking->quantity }}</p>

        @if($booking->status !== 'confirmed')

            <h2 style="color:#f87171;">
                VÉ KHÔNG HỢP LỆ
            </h2>

            <p>Vé chưa được xác nhận hoặc đã bị hủy.</p>

        @elseif($booking->used_at)

            <h2 style="color:#f87171;">
                VÉ ĐÃ SỬ DỤNG
            </h2>

            <p>
                Thời gian sử dụng:
                {{ \Carbon\Carbon::parse($booking->used_at)->format('d/m/Y H:i:s') }}
            </p>

@elseif(!$booking->showtime || !$booking->showtime->starts_at)

    <h2 style="color:#f87171;">
        KHÔNG CÓ THÔNG TIN SUẤT CHIẾU
    </h2>

    <p>Không thể xác nhận sử dụng vé.</p>

@elseif(now()->lt($booking->showtime->starts_at->copy()->subMinutes(30)))

    <h2 style="color:#fbbf24;">
        CHƯA ĐẾN GIỜ KIỂM VÉ
    </h2>

    <p>
        Vé chỉ được sử dụng từ 30 phút
        trước giờ chiếu.
    </p>



        @else

            <h2 style="color:#4ade80;">
                VÉ HỢP LỆ
            </h2>

            <p>Vé đã xác nhận và chưa được sử dụng.</p>

            <form method="POST"
                  action="{{ route('admin.tickets.use', ['id' => $booking->id]) }}"
                  onsubmit="return confirm('Xác nhận vé này đã sử dụng?');">

                @csrf

                <button type="submit"
                        style="background:#ff914d;
                               color:#111827;
                               padding:12px 20px;
                               border:none;
                               border-radius:8px;
                               font-weight:bold;
                               cursor:pointer;
                               margin-top:20px;">
                    XÁC NHẬN VÉ ĐÃ SỬ DỤNG
                </button>

            </form>

        @endif

    </div>

</div>

<div style="
    text-align:center;
    margin:20px auto 50px;
    padding:0 20px;
">
    <a href="{{ route('admin.tickets.lookup') }}"
       style="
           display:inline-block;
           background:#ff914d;
           color:#111827;
           padding:14px 25px;
           border-radius:10px;
           font-weight:bold;
           text-decoration:none;
       ">
        ← QUÉT VÉ TIẾP THEO
    </a>
</div>

@endsection
