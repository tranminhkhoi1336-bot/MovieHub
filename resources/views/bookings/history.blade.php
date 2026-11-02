
@extends('layouts.main')

@section('content')

<div style="max-width:1200px; margin:50px auto; padding:20px; min-height:500px;">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:20px;">
        LỊCH SỬ ĐẶT VÉ
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Danh sách các vé xem phim bạn đã đặt trên MovieHub.
    </p>

    
<div class="mh-history-scroll"
     style="background:#2d3748; padding:20px;
            border-radius:12px; overflow-x:auto;">


        
<table class="mh-history-table"
       style="width:100%; border-collapse:collapse; text-align:left;">

            <thead>
                <tr style="color:#ff914d; border-bottom:1px solid #64748b;">
                    <th style="padding:12px;">Mã đơn</th>
                    <th style="padding:12px;">Tên phim</th>
                    <th style="padding:12px;">Ngày giờ chiếu</th>
                    <th style="padding:12px;">Số vé</th>
                    
                    <th style="padding:12px;">Ghế đã chọn</th>

                    <th style="padding:12px;">Tổng tiền</th>
                    <th style="padding:12px;">Trạng thái</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)
                    <tr style="border-bottom:1px solid #475569;">

                        <td style="padding:12px;">
                            #{{ $booking->id }}
                        </td>

                        <td style="padding:12px;">
                            {{ optional(optional($booking->showtime)->movie)->title ?? 'Không xác định' }}
                        </td>

                        <td style="padding:12px;">
                            @if($booking->showtime && $booking->showtime->starts_at)
                                {{ $booking->showtime->starts_at->format('d/m/Y H:i') }}
                            @else
                                Không xác định
                            @endif
                        </td>

                        <td style="padding:12px;">
                            {{ $booking->quantity }}
                        </td>

                        <td style="padding:12px;">
                            @if(is_array($booking->seat_codes) && count($booking->seat_codes) > 0)
                                {{ implode(', ', $booking->seat_codes) }}
                            @else
                                Chưa gán ghế
                            @endif
                        </td>

                        <td style="padding:12px;">
                            {{ number_format($booking->total_price, 0, ',', '.') }} đ
                        </td>

                        <td style="padding:12px;">
                           
@if($booking->status === 'pending')
    <span style="color:#fbbf24;">
        Chờ thanh toán
    </span>

                                

@if($booking->status === 'pending'
    && $booking->showtime
    && $booking->showtime->starts_at->gt(now()))

    <a href="{{ route('customer.bookings.payment', ['id' => $booking->id]) }}"
       style="display:table;
              margin-top:10px;
              padding:10px 16px;
              background:#ff914d;
              color:#111827;
              border-radius:8px;
              font-weight:bold;
              text-decoration:none;">
        Thanh toán VietQR
    </a>

@endif

                            @elseif($booking->status == 'confirmed' && $booking->used_at)
                                <span style="color:#f87171; font-weight:bold;">
                                    Đã sử dụng
                                </span>

                            @elseif($booking->status == 'confirmed')
                                <span style="color:#4ade80;">
                                    Đã xác nhận
                                </span>
                            @elseif($booking->status == 'cancelled')
                                <span style="color:#f87171;">
                                    Đã hủy
                                </span>
                            @else
                                {{ $booking->status }}
                            @endif
                            
                            @if($booking->status === 'confirmed')
                                <div style="margin-top:10px;">
                                    <a href="{{ route('customer.bookings.ticket', ['id' => $booking->id]) }}"
                                    style="display:inline-block;
                                            background:#ff914d;
                                            color:#111827;
                                            padding:8px 12px;
                                            border-radius:6px;
                                            font-weight:bold;
                                            text-decoration:none;">
                                        🎟 Xem vé điện tử
                                    </a>
                                </div>
                            @endif

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7"
                            style="padding:30px; text-align:center; color:#cbd5e1;">
                            Bạn chưa có đơn đặt vé nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div style="margin-top:25px;">
        {{ $bookings->links() }}
    </div>

    <a href="{{ route('customer.bookings.create') }}"
       style="display:inline-block;
              background:#ff914d;
              color:#111827;
              padding:12px 22px;
              border-radius:8px;
              font-weight:bold;
              text-decoration:none;
              margin-top:25px;">
        + Đặt vé mới
    </a>

</div>

@endsection
