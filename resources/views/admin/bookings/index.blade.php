
@extends('layouts.main')

@section('content')

<style>
/* RESPONSIVE QUAN LY DAT VE MOVIEHUB */
@media (max-width: 640px) {

.booking-customer-info {
    min-width: 0;
    max-width: 100%;
    overflow-wrap: anywhere;
    line-height: 1.6;
}

    /* Khung trang */
    .booking-admin-page {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        margin: 15px auto !important;
        padding: 12px !important;
        box-sizing: border-box;
    }

    /* Tieu de trang */
    .booking-admin-page h1 {
        font-size: 23px !important;
        line-height: 1.4 !important;
    }

    /* Khung danh sach dat ve */
    .booking-table-box {
        width: 100% !important;
        max-width: 100% !important;
        padding: 12px !important;
        overflow-x: visible !important;
        box-sizing: border-box;
    }

    /* Chuyen bang thanh danh sach the */
    .booking-table-box > table,
    .booking-table-box > table > tbody {
        display: block !important;
        width: 100% !important;
        min-width: 0 !important;
    }

    /* An tieu de bang tren dien thoai */
    .booking-table-box > table > thead {
        display: none !important;
    }

    /* Moi don dat ve la mot the */
    .booking-table-box > table > tbody > tr {
        display: block !important;
        width: 100% !important;
        margin-bottom: 14px !important;
        padding: 12px !important;
        background: #1b293b !important;
        border: 1px solid #475569 !important;
        border-radius: 12px !important;
        box-sizing: border-box;
    }

    /* Thong tin ben trong the */
    .booking-table-box > table > tbody > tr > td {
        display: grid !important;
        grid-template-columns: 90px minmax(0, 1fr);
        align-items: start;
        gap: 8px;
        width: 100% !important;
        min-width: 0 !important;
        padding: 8px 0 !important;
        border: none !important;
        color: white;
        font-size: 13px;
        line-height: 1.5;
        overflow-wrap: anywhere;
        white-space: normal !important;
        box-sizing: border-box;
    }

    /* Nhan cho tung dong thong tin */
    .booking-table-box > table > tbody > tr > td::before {
        color: #ff914d;
        font-weight: bold;
        font-size: 13px;
    }

    .booking-table-box > table > tbody > tr > td:nth-child(1)::before {
        content: "Mã đơn:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(2)::before {
        content: "Khách hàng:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(3)::before {
        content: "Tên phim:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(4)::before {
        content: "Suất chiếu:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(5)::before {
        content: "Số vé:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(6)::before {
        content: "Ghế đã chọn:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(7)::before {
        content: "Tổng tiền:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(8)::before {
        content: "Trạng thái:";
    }

    .booking-table-box > table > tbody > tr > td:nth-child(9)::before {
        content: "Thao tác:";
    }

    /* Cac nut thao tac */
    .booking-table-box > table > tbody > tr > td:last-child > div {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center;
        gap: 8px !important;
        min-width: 0;
    }

    .booking-table-box > table > tbody > tr > td:last-child a,
    .booking-table-box > table > tbody > tr > td:last-child button {
        max-width: 100%;
        box-sizing: border-box;
        white-space: normal;
    }

    /* Neu chua co don dat ve */
    .booking-table-box > table > tbody > tr > td[colspan] {
        display: block !important;
        width: 100% !important;
        padding: 16px !important;
        text-align: center !important;
    }

    .booking-table-box > table > tbody > tr > td[colspan]::before {
        content: none !important;
    }

    /* Phan trang */
    .booking-admin-page .pagination {
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: center;
        gap: 8px;
        padding: 0;
    }
}
</style>


<div class="booking-admin-page"
     style="max-width:1300px; margin:50px auto; padding:20px; min-height:500px;">


    <h1 style="font-size:30px; font-weight:bold; margin-bottom:20px;">
        QUẢN LÝ ĐẶT VÉ
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Danh sách các đơn đặt vé trong hệ thống MovieHub
    </p>

    @if(session('success'))
        <div style="background:#166534; padding:15px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#991b1b; padding:15px; border-radius:8px; margin-bottom:20px;">
            {{ session('error') }}
        </div>
    @endif

    
<div class="booking-table-box"
     style="background:#2d3748; padding:20px; border-radius:12px; overflow-x:auto;">


        <table style="width:100%; border-collapse:collapse; text-align:left;">

            <thead>
                <tr style="color:#ff914d; border-bottom:1px solid #64748b;">
                    <th style="padding:12px;">ID</th>
                    <th style="padding:12px;">Khách hàng</th>
                    <th style="padding:12px;">Tên phim</th>
                    <th style="padding:12px;">Suất chiếu</th>
                    <th style="padding:12px;">Số vé</th>
                    
                    <th style="padding:12px;">Ghế đã chọn</th>

                    <th style="padding:12px;">Tổng tiền</th>
                    <th style="padding:12px;">Trạng thái</th>
                    
                    <th style="padding:12px;">Thao tác</th>

                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)

                    <tr style="border-bottom:1px solid #475569;">

                        <td style="padding:12px;">
                            {{ $booking->id }}
                        </td>

                        
<td style="padding:12px;">
    <div class="booking-customer-info">
        <div>
            {{ optional($booking->user)->name ?? 'Không xác định' }}
        </div>

        <div style="font-size:13px; color:#cbd5e1;">
            {{ optional($booking->user)->email }}
        </div>
    </div>
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
    <span style="color:#fbbf24; font-weight:bold;">
        Chờ xác nhận
    </span>

@elseif($booking->status === 'confirmed' && $booking->used_at)
    <span style="color:#f87171; font-weight:bold;">
        Đã sử dụng
    </span>

@elseif($booking->status === 'confirmed')
    <span style="color:#4ade80; font-weight:bold;">
        Đã xác nhận
    </span>

@elseif($booking->status === 'cancelled')
    <span style="color:#f87171; font-weight:bold;">
        Đã hủy
    </span>

@else
    {{ $booking->status }}
@endif


                        </td>

<td style="padding:12px;">

    @if($booking->status == 'pending')

        <div style="display:flex; gap:10px;">

     
@if(
    $booking->showtime &&
    $booking->showtime->starts_at->gt(now())
)
<a href="{{ route('admin.bookings.payment.form', $booking->id) }}"

   style="
       display:inline-block;
       background:#22c55e;
       color:#111827;
       padding:12px 16px;
       border-radius:8px;
       font-weight:bold;
       text-decoration:none;
       white-space:nowrap;
   ">
    Xác minh thanh toán
</a>

@else
    <span style="color:#f87171; font-weight:bold;">
        Suất chiếu không còn hợp lệ
    </span>
@endif


            <form action="{{ route('admin.bookings.status', $booking->id) }}"
                  method="POST"
                  style="margin:0;"
                  onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn này?');">

                @csrf
                @method('PATCH')

                <input type="hidden" name="status" value="cancelled">

                <button type="submit"
                        style="background:#dc2626;
                               color:white;
                               padding:8px 14px;
                               border-radius:6px;
                               cursor:pointer;">
                    Hủy đơn
                </button>

            </form>

        </div>

    @else

        
@if($booking->status === 'confirmed')

    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute('admin.tickets.verify', ['id' => $booking->id]) }}"
       style="
           display:inline-block;
           background:#ff914d;
           color:#111827;
           padding:10px 16px;
           border-radius:8px;
           font-weight:bold;
           text-decoration:none;
           white-space:nowrap;
       ">
        Kiểm vé
    </a>

@else

    <span style="color:#cbd5e1;">
        Đã xử lý
    </span>

@endif

    @endif

</td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="9"
                            style="padding:30px; text-align:center; color:#cbd5e1;">
                            Chưa có đơn đặt vé nào trong hệ thống.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div style="margin-top:25px;">
        {{ $bookings->links() }}
    </div>

    <a href="{{ route('admin.dashboard') }}"
       style="display:inline-block; margin-top:25px; color:#ff914d; text-decoration:none;">
        ← Quay lại trang quản trị
    </a>

</div>

@endsection
