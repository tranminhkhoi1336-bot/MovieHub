
@extends('layouts.main')

@section('content')

<style>
.mh-payment-page {
    max-width: 780px;
    margin: 55px auto 90px;
    padding: 20px;
    color: white;
}

.mh-payment-card {
    background: #29364b;
    border: 1px solid #465670;
    border-radius: 22px;
    padding: 35px;
    text-align: center;
}

.mh-payment-title {
    color: #ff914d;
    font-size: 30px;
    font-weight: 900;
    margin-bottom: 16px;
}

.mh-payment-subtitle {
    color: #cbd5e1;
    margin-bottom: 25px;
}

.mh-payment-info {
    background: #182436;
    padding: 20px;
    border-radius: 12px;
    text-align: left;
    line-height: 2;
    margin-bottom: 25px;
}

.mh-payment-amount {
    font-size: 32px;
    font-weight: 900;
    color: #ff914d;
}

.mh-payment-qr {
    width: 100%;
    max-width: 360px;
    height: auto;
    margin: 20px auto;
    background: white;
    border-radius: 14px;
    padding: 8px;
}

.mh-payment-notice {
    color: #fbbf24;
    line-height: 1.8;
    margin-top: 20px;
}

.mh-payment-deadline {
    background: #3b342d;
    border: 1px solid #f59e0b;
    border-radius: 12px;
    padding: 20px;
    margin: 20px 0 30px;
    text-align: left;
    color: #f8fafc;
    line-height: 1.8;
}

.mh-payment-deadline strong {
    color: #fbbf24;
}

.mh-payment-deadline p {
    margin: 8px 0;
}

.mh-payment-deadline-title {
    color: #ff914d;
    font-size: 19px;
    font-weight: bold;
    margin-bottom: 10px;
}

.mh-payment-back {
    display: inline-block;
    margin-top: 25px;
    color: #ff914d;
    text-decoration: none;
}

@media(max-width: 600px) {
    .mh-payment-card {
        padding: 22px 15px;
    }
}
</style>

<div class="mh-payment-page">

    <div class="mh-payment-card">

        <h1 class="mh-payment-title">
            THANH TOÁN VÉ MOVIEHUB
        </h1>

        <p class="mh-payment-subtitle">
            Quét mã VietQR bằng ứng dụng ngân hàng.
        </p>

        <div class="mh-payment-info">

            <p>
                <strong>Mã đơn:</strong>
                #{{ $booking->id }}
            </p>

            <p>
                <strong>Phim:</strong>
                {{ optional($booking->showtime->movie)->title }}
            </p>

            <p>
                <strong>Ghế:</strong>
                {{ implode(', ', $booking->seat_codes ?? []) }}
            </p>

            <p>
                <strong>Số lượng:</strong>
                {{ $booking->quantity }} vé
            </p>

            <p>
                <strong>Nội dung chuyển khoản:</strong>
                {{ $paymentContent }}
            </p>

            <p>
                <strong>Tổng thanh toán:</strong>
            </p>

            <div class="mh-payment-amount">
                {{ number_format($amount, 0, ',', '.') }} đ
            </div>

       
        </div>

        



<div id="mh-qr-section">

        @if($qrUrl)


            <h2 style="color:#ff914d;
                       font-size:21px;
                       font-weight:bold;">
                QUÉT MÃ ĐỂ THANH TOÁN
            </h2>

            <img
                src="{{ $qrUrl }}"
                alt="Mã VietQR thanh toán đơn MovieHub"
                class="mh-payment-qr">

            <p>
                Ngân hàng: {{ $bankId }}
            </p>

            <p>
                Số tài khoản: {{ $accountNo }}
            </p>

            <p>
                Chủ tài khoản: {{ $accountName }}
            </p>

        @else

            <p class="mh-payment-notice">
                Chưa cấu hình tài khoản nhận thanh toán VietQR.
            </p>

        @endif
</div>
        <p id="mh-payment-pending-notice"
   class="mh-payment-notice">
            Đơn hàng đang chờ xác minh thanh toán.
            Vé điện tử chỉ được cấp sau khi giao dịch
            được xác nhận thành công.
        </p>

        <a href="{{ route('customer.bookings.history') }}"
           class="mh-payment-back">
            ← Xem lịch sử đặt vé
        </a>

    </div>
</div>





@endsection
