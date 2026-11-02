
@extends('layouts.main')

@section('content')

<div style="
    max-width:700px;
    margin:50px auto;
    padding:30px;
    background:#2d3748;
    border-radius:16px;
    color:white;
">

    <h1 style="
        color:#ff914d;
        font-size:28px;
        font-weight:bold;
        margin-bottom:25px;
    ">
        XÁC MINH THANH TOÁN
    </h1>

    <div style="
        background:#182436;
        padding:20px;
        border-radius:10px;
        line-height:2;
        margin-bottom:25px;
    ">
        <p>Mã đơn: #{{ $booking->id }}</p>

        <p>
            Khách hàng:
            {{ optional($booking->user)->name }}
        </p>

        <p>
            Phim:
            {{ optional($booking->showtime->movie)->title }}
        </p>

        <p>
            Tổng tiền:
            <strong style="color:#ff914d;">
                {{ number_format($booking->total_price, 0, ',', '.') }} đ
            </strong>
        </p>

        <p>
            Nội dung chuyển khoản:
            MOVIEHUB{{ $booking->id }}
        </p>
    </div>

    @if($errors->any())
        <div style="color:#f87171; margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.bookings.payment.confirm', $booking->id) }}">

        @csrf

        <label>Mã giao dịch ngân hàng</label>
        <input type="text"
               name="payment_reference"
               value="{{ old('payment_reference') }}"
               required
               maxlength="100"
               style="width:100%;
                      padding:12px;
                      margin:10px 0 20px;
                      border-radius:8px;
                      color:#111827;">

        <label>Số tiền thực nhận (VNĐ)</label>
        <input type="number"
               name="paid_amount"
               value="{{ old('paid_amount') }}"
               min="1"
               step="1"
               required
               style="width:100%;
                      padding:12px;
                      margin:10px 0 20px;
                      border-radius:8px;
                      color:#111827;">

        <label style="
            display:flex;
            gap:10px;
            align-items:flex-start;
            margin-bottom:25px;
            line-height:1.6;
        ">
            <input type="checkbox"
                   name="bank_verified"
                   value="1"
                   required
                   style="margin-top:6px;">

            Tôi đã kiểm tra giao dịch thực nhận
            trên tài khoản ngân hàng và đối chiếu
            đúng số tiền, nội dung chuyển khoản,
            mã giao dịch của đơn hàng.
        </label>

        <button type="submit"
                style="
                    background:#22c55e;
                    color:#111827;
                    padding:14px 22px;
                    border:0;
                    border-radius:9px;
                    font-weight:bold;
                    cursor:pointer;
                ">
            XÁC NHẬN ĐÃ NHẬN TIỀN
        </button>

        <a href="{{ route('admin.bookings.index') }}"
           style="
               color:#ff914d;
               margin-left:15px;
               text-decoration:none;
           ">
            Quay lại
        </a>

    </form>

</div>

@endsection
