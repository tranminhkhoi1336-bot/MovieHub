
@extends('layouts.main')

@section('content')

@php
    $verifyUrl = \Illuminate\Support\Facades\URL::signedRoute(
        'admin.tickets.verify',
        ['id' => $booking->id]
    );
@endphp

<style>

@media print {
    nav,
    footer,
    .ticket-actions,
    .ticket-back {
        display: none !important;
    }

    @page {
        size: A4;
        margin: 15mm;
    }

    body {
        background: white !important;
    }

    .ticket-card {
        background: white !important;
        border: 2px solid #333 !important;
        box-shadow: none !important;
        padding: 30px !important;
    }

    .ticket-card,
    .ticket-card * {
        color: #111827 !important;
    }

    .ticket-card h1 {
        color: #c65c14 !important;
        font-size: 24pt !important;
    }

    .ticket-card h2 {
        color: #c65c14 !important;
        font-size: 20pt !important;
    }

    .ticket-card p {
        font-size: 14pt !important;
        line-height: 1.7 !important;
    }
}

/* BUOC 451.17 - TOI UU VE DIEN TU TREN DIEN THOAI */

@media screen and (max-width: 767px) {

    /* Khung ve gon hon */
    .ticket-card {
        padding: 18px 14px !important;
        box-sizing: border-box;
    }

    /* Tieu de ve */
    .ticket-card > h1 {
        font-size: 22px !important;
        line-height: 1.35 !important;
        text-align: center !important;
        margin-bottom: 15px !important;
    }

    /* Ten phim */
    .ticket-card > h2 {
        font-size: 21px !important;
        line-height: 1.4 !important;
        overflow-wrap: break-word;
    }

    /* Tieu de ma QR */
    .ticket-card h3 {
        font-size: 18px !important;
        line-height: 1.4 !important;
    }

    /* Khung QR */
    #ticketQrCode {
        padding: 10px !important;
        max-width: 100% !important;
        box-sizing: border-box;
    }

    /* Thu nho ma QR tren dien thoai */
    #ticketQrCode img,
    #ticketQrCode canvas {
        max-width: 220px !important;
        max-height: 220px !important;
        width: auto !important;
        height: auto !important;
    }

}

</style>

<div style="max-width:750px; margin:50px auto; padding:20px;">

    <div style="background:#2d3748; padding:30px;
                border-radius:15px; color:white;"
                class="ticket-card">

        <h1 style="color:#ff914d; font-size:30px;">
            VÉ XEM PHIM MOVIEHUB
        </h1>

        <hr style="border:1px solid #475569; margin:20px 0;">

        <h2 style="color:#ff914d; font-size:26px;">
            {{ $booking->showtime->movie->title }}
        </h2>

        <p>Mã vé: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>

        <p>
            Ngày giờ chiếu:
            {{ $booking->showtime->starts_at->format('d/m/Y H:i') }}
        </p>

        <p>
            Ghế:
            {{ implode(', ', $booking->seat_codes ?? []) }}
        </p>

        <p>Số lượng vé: {{ $booking->quantity }}</p>

        <p>
            Tổng tiền:
            {{ number_format($booking->total_price, 0, ',', '.') }} đ
        </p>

        
@if($booking->used_at)
    <p style="color:#f87171; font-weight:bold; margin-top:10px;">
        ĐÃ SỬ DỤNG
    </p>
@else
    <p style="color:#4ade80; font-weight:bold; margin-top:10px;">
        ĐÃ XÁC NHẬN
    </p>
@endif

<div style="margin-top:25px; text-align:center;">
    <h3 style="color:#ff914d; margin-bottom:15px;">
        MÃ QR XÁC THỰC VÉ
    </h3>

    
<div id="ticketQrCode"
     data-verify-url="{{ $verifyUrl }}"

         style="display:table;
                margin:0 auto;
                padding:15px;
                background:white;
                border-radius:10px;">
    </div>

    <p style="margin-top:12px;">
        Xuất trình mã QR khi kiểm vé
    </p>
</div>

    </div>

    
<div class="ticket-actions"
     style="display:flex; gap:12px; flex-wrap:wrap; margin-top:20px;">

    <button type="button"
            onclick="window.print()"
            style="background:#ff914d;
                   color:#111827;
                   padding:12px 20px;
                   border:none;
                   border-radius:8px;
                   font-weight:bold;
                   cursor:pointer;">
        In vé / Lưu PDF
    </button>

    



</div>

<a href="{{ route('customer.bookings.history') }}"
   class="ticket-back"
   style="display:inline-block;
          margin-top:20px;
          color:#ff914d;">
    ← Quay lại lịch sử đặt vé
</a>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    if (typeof QRCode !== 'undefined') {
        new QRCode(document.getElementById('ticketQrCode'), {
            
text: document.getElementById('ticketQrCode').getAttribute('data-verify-url'),

            width: 220,
            height: 220,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
        });
    }
</script>

@endsection
