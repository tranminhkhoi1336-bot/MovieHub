
@extends('layouts.main')

@section('content')
<style>
/* RESPONSIVE QUAN LY SUAT CHIEU MOVIEHUB */
@media (max-width: 640px) {

    /* Khung trang */
    .showtime-admin-page {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        margin: 15px auto !important;
        padding: 12px !important;
        box-sizing: border-box;
    }

    .showtime-admin-page h1 {
        font-size: 23px !important;
        line-height: 1.4 !important;
    }

    /* Khung danh sach */
    .showtime-table-box {
        width: 100% !important;
        padding: 12px !important;
        overflow-x: visible !important;
        box-sizing: border-box;
    }

    /* Chuyen bang thanh the */
    .showtime-admin-page table,
    .showtime-admin-page tbody {
        display: block !important;
        width: 100% !important;
        min-width: 0 !important;
    }

    .showtime-admin-page thead {
        display: none !important;
    }

    /* Moi suat chieu la mot the */
    .showtime-admin-page tbody tr {
        display: block !important;
        width: 100% !important;
        margin-bottom: 14px !important;
        padding: 12px !important;
        background: #1b293b;
        border: 1px solid #475569 !important;
        border-radius: 12px;
        box-sizing: border-box;
    }

    /* Thong tin trong the */
    .showtime-admin-page tbody td {
        display: grid !important;
        grid-template-columns: 95px minmax(0, 1fr);
        gap: 8px;
        align-items: start;
        width: 100% !important;
        min-width: 0 !important;
        padding: 8px 0 !important;
        border: none !important;
        color: white;
        font-size: 14px;
        line-height: 1.5;
        overflow-wrap: anywhere;
        white-space: normal !important;
        box-sizing: border-box;
    }

    /* Nhan thong tin */
    .showtime-admin-page tbody td::before {
        color: #ff914d;
        font-weight: bold;
        font-size: 13px;
    }

    .showtime-admin-page td:nth-child(1)::before {
        content: "Mã suất:";
    }

    .showtime-admin-page td:nth-child(2)::before {
        content: "Tên phim:";
    }

    .showtime-admin-page td:nth-child(3)::before {
        content: "Ngày giờ:";
    }

    .showtime-admin-page td:nth-child(4)::before {
        content: "Giá vé:";
    }

    .showtime-admin-page td:nth-child(5)::before {
        content: "Tổng ghế:";
    }

    .showtime-admin-page td:nth-child(6)::before {
        content: "Trạng thái:";
    }

    .showtime-admin-page td:nth-child(7)::before {
        content: "Thao tác:";
    }

    /* Nut sua va xoa */
    .showtime-admin-page tbody td:last-child > div {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center;
        gap: 8px !important;
        min-width: 0;
    }

    /* Truong hop chua co suat chieu */
    .showtime-admin-page td[colspan] {
        display: block !important;
        padding: 16px !important;
        text-align: center;
    }

    .showtime-admin-page td[colspan]::before {
        content: none !important;
    }

    /* Phan trang */
    .showtime-admin-page .pagination {
        display: flex !important;
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        padding: 0;
    }
}
</style>


<div class="showtime-admin-page"
     style="max-width:1200px; margin:50px auto; padding:20px; min-height:500px;">

@if(session('success'))
    <div style="background:#166534; color:white; padding:15px;
                border-radius:8px; margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#991b1b; color:white; padding:15px;
                border-radius:8px; margin-bottom:20px;">
        {{ session('error') }}
    </div>
@endif


    <h1 style="font-size:30px; font-weight:bold; margin-bottom:20px;">
        QUẢN LÝ SUẤT CHIẾU
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Danh sách các suất chiếu phim trong hệ thống MovieHub
    </p>

<a href="{{ route('admin.showtimes.create') }}"
   style="display:inline-block;
          background:#ff914d;
          color:#111827;
          padding:12px 22px;
          border-radius:8px;
          font-weight:bold;
          text-decoration:none;
          margin-bottom:25px;">
    + Thêm suất chiếu mới
</a>

    <div class="showtime-table-box"
     style="overflow-x:auto; background:#2d3748; padding:20px; border-radius:12px;">
        <table style="width:100%; border-collapse:collapse; text-align:left;">

            <thead>
                <tr style="color:#ff914d; border-bottom:1px solid #64748b;">
                    <th style="padding:12px;">ID</th>
                    <th style="padding:12px;">Tên phim</th>
                    <th style="padding:12px;">Ngày giờ chiếu</th>
                    <th style="padding:12px;">Giá vé</th>
                    <th style="padding:12px;">Tổng ghế</th>
                    <th style="padding:12px;">Trạng thái</th>
                    
                    <th style="padding:12px;">Thao tác</th>

                </tr>
            </thead>

            <tbody>
                @forelse($showtimes as $showtime)
                    <tr style="border-bottom:1px solid #475569;">

                        <td style="padding:12px;">
                            {{ $showtime->id }}
                        </td>

                        <td style="padding:12px;">
                            {{ optional($showtime->movie)->title ?? 'Không xác định' }}
                        </td>

                        <td style="padding:12px;">
                            {{ $showtime->starts_at ? \Carbon\Carbon::parse($showtime->starts_at)->format('d/m/Y H:i') : 'Chưa xác định' }}
                        </td>

                        <td style="padding:12px;">
                            {{ number_format($showtime->price, 0, ',', '.') }} đ
                        </td>

                        <td style="padding:12px;">
                            {{ $showtime->total_seats }}
                        </td>

                        <td style="padding:12px;">
                            {{ $showtime->status }}
                        </td>
                        
                        
<td style="padding:12px;">
    <div style="display:flex; gap:10px; align-items:center;">

        <a href="{{ route('admin.showtimes.edit', $showtime->id) }}"
           style="display:inline-block;
                  background:#ff914d;
                  color:#111827;
                  padding:8px 16px;
                  border-radius:6px;
                  font-weight:bold;
                  text-decoration:none;">
            Sửa
        </a>

        <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}"
              method="POST"
              style="margin:0;"
              onsubmit="return confirm('Bạn có chắc chắn muốn xóa suất chiếu này?');">

            @csrf
            @method('DELETE')

            <button type="submit"
                    style="background:#dc2626;
                           color:white;
                           padding:8px 16px;
                           border-radius:6px;
                           font-weight:bold;
                           cursor:pointer;">
                Xóa
            </button>
        </form>

    </div>
</td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="7"
                            style="padding:25px; text-align:center; color:#cbd5e1;">
                            Chưa có suất chiếu nào trong hệ thống.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div style="margin-top:25px;">
        {{ $showtimes->links() }}
    </div>

    <a href="{{ route('admin.dashboard') }}"
       style="display:inline-block; margin-top:25px; color:#ff914d;">
        ← Quay lại trang quản trị
    </a>

</div>



@endsection
