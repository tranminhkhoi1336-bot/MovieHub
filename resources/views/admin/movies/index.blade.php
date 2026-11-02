
@extends('layouts.main')

@section('content')

<div 

@if(session('success'))
    <div style="background:#166534;
                color:white;
                padding:15px;
                border-radius:8px;
                margin-bottom:20px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#991b1b;
                color:white;
                padding:15px;
                border-radius:8px;
                margin-bottom:20px;">
        {{ session('error') }}
    </div>
@endif


<div class="movie-admin-page"
style="max-width:1200px; margin:50px auto; padding:20px; min-height:450px;">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:20px;">
        QUẢN LÝ PHIM
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Danh sách các phim trong hệ thống MovieHub
    </p>

<a href="{{ route('admin.movies.create') }}"
   style="display:inline-block;
          background:#ff914d;
          color:#111827;
          padding:12px 22px;
          border-radius:8px;
          font-weight:bold;
          text-decoration:none;
          margin-bottom:25px;">
    + Thêm phim mới
</a>

<!-- TIM KIEM PHIM -->
<form class="movie-admin-search" method="GET"
      action="{{ route('admin.movies.index') }}"
      style="display:flex;
             gap:10px;
             flex-wrap:wrap;
             margin-bottom:20px;">

    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Nhập tên phim cần tìm..."
           style="flex:1;
                  min-width:180px;
                  padding:12px;
                  background:white;
                  color:#111827;
                  border:1px solid #64748b;
                  border-radius:8px;">

    <button type="submit"
            style="background:#ff914d;
                   color:#111827;
                   padding:12px 22px;
                   border:none;
                   border-radius:8px;
                   font-weight:bold;
                   cursor:pointer;">
        Tìm kiếm
    </button>

    <a href="{{ route('admin.movies.index') }}"
       style="background:#475569;
              color:white;
              padding:12px 18px;
              border-radius:8px;
              text-decoration:none;">
        Xóa lọc
    </a>

</form>
<!-- KET THUC TIM KIEM -->

    <div style="overflow-x:auto; background:#2d3748; padding:20px; border-radius:12px;">

        <table style="width:100%; border-collapse:collapse; text-align:left;">

            <thead>
                <tr style="color:#ff914d; border-bottom:1px solid #64748b;">
                    <th style="padding:12px;">ID</th>
                    <th style="padding:12px;">Tên phim</th>
                    <th style="padding:12px;">Thể loại</th>
                    <th style="padding:12px;">Thời lượng</th>
                    <th style="padding:12px;">Trạng thái</th>
                    <th style="padding:12px;">Thao tác</th>

                </tr>
            </thead>

            <tbody>
                @forelse($movies as $movie)
                    <tr style="border-bottom:1px solid #475569;">
                        <td style="padding:12px;">{{ $movie->id }}</td>
                        <td style="padding:12px;">{{ $movie->title }}</td>
                        <td style="padding:12px;">{{ $movie->genre }}</td>
                        <td style="padding:12px;">
                            {{ $movie->duration }} phút
                        </td>
                        <td style="padding:12px;">
                            {{ $movie->status }}
                        </td>
                        
                        
<td style="padding:12px;">
    <div style="display:flex; gap:10px; align-items:center;">

        <a href="{{ route('admin.movies.edit', $movie->id) }}"
           style="background:#ff914d;
                  color:#111827;
                  padding:8px 16px;
                  border-radius:6px;
                  font-weight:bold;
                  text-decoration:none;">
            Sửa
        </a>

        <form action="{{ route('admin.movies.destroy', $movie->id) }}"
              method="POST"
              style="margin:0;"
              onsubmit="return confirm('Bạn có chắc chắn muốn xóa phim này?');">

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
                        <td colspan="6"
                            style="padding:25px; text-align:center; color:#cbd5e1;">
                            Chưa có phim nào trong cơ sở dữ liệu.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div style="margin-top:25px;">
        {{ $movies->links() }}
    </div>

    <a href="{{ route('admin.dashboard') }}"
       style="display:inline-block; margin-top:25px; color:#ff914d;">
        ← Quay lại trang quản trị
    </a>

</div>

<style>
/* Phan trang quan ly phim MovieHub */
.pagination {
    display: flex !important;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.pagination li {
    list-style: none;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    height: 42px;
    padding: 8px 12px;
    background: #2d3748;
    color: white;
    border: 1px solid #475569;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}

.pagination li a:hover {
    background: #ff914d;
    color: #111827;
}

.pagination .active span {
    background: #ff914d;
    color: #111827;
    border-color: #ff914d;
}

.pagination .disabled span {
    opacity: 0.4;
    cursor: not-allowed;
}

</style>


<style>
/* Responsive rieng cho trang quan ly phim */
@media (max-width: 640px) {

    .movie-admin-page {
        width: 100% !important;
        max-width: 100% !important;
        margin: 15px auto !important;
        padding: 12px !important;
        min-width: 0 !important;
    }

    .movie-admin-page h1 {
        font-size: 24px !important;
        line-height: 1.4;
    }

    /* Chuyen bang thanh cac the phim */
    .movie-admin-page table,
    .movie-admin-page tbody {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .movie-admin-page thead {
        display: none !important;
    }

    .movie-admin-page tbody tr {
        display: block !important;
        width: 100% !important;
        background: #1b293b;
        border: 1px solid #475569 !important;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 14px;
    }

    .movie-admin-page tbody td {
        display: block !important;
        position: relative;
        width: 100% !important;
        min-width: 0 !important;
        padding: 8px 0 8px 100px !important;
        border: none !important;
        color: white;
        font-size: 14px;
        line-height: 1.5;
        overflow-wrap: anywhere;
        white-space: normal !important;
    }

    /* Tao nhan cho tung thong tin */
    .movie-admin-page tbody td::before {
        position: absolute;
        left: 0;
        top: 8px;
        width: 92px;
        color: #ff914d;
        font-weight: 700;
    }

    .movie-admin-page td:nth-child(1)::before {
        content: "ID:";
    }

    .movie-admin-page td:nth-child(2)::before {
        content: "Tên phim:";
    }

    .movie-admin-page td:nth-child(3)::before {
        content: "Thể loại:";
    }

    .movie-admin-page td:nth-child(4)::before {
        content: "Thời lượng:";
    }

    .movie-admin-page td:nth-child(5)::before {
        content: "Trạng thái:";
    }

    .movie-admin-page td:nth-child(6)::before {
        content: "Thao tác:";
    }

    /* Truong hop khong co phim */
    .movie-admin-page td[colspan] {
        padding: 15px !important;
        text-align: center;
    }

    .movie-admin-page td[colspan]::before {
        content: none !important;
    }

    /* Nut sua, xoa */
    .movie-admin-page tbody td:last-child a,
    .movie-admin-page tbody td:last-child button {
        margin: 3px 4px 3px 0;
    }

    /* Phan trang */
    .movie-admin-page .pagination {
        display: flex !important;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
        padding: 0;
    }
}
</style>

<style>
/* Giao dien tim kiem tren dien thoai */
@media (max-width: 640px) {

    /* Sap xep form tim kiem */
    .movie-admin-page .movie-admin-search {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 10px !important;
        width: 100% !important;
        align-items: stretch;
    }

    /* O nhap ten phim chiem ca dong */
    .movie-admin-search input[name="search"] {
        flex: 0 0 100% !important;
        width: 100% !important;
        min-width: 0 !important;
        height: 46px;
        box-sizing: border-box;
    }

    /* Hai nut nam ngang va bang nhau */
    .movie-admin-search button[type="submit"],
    .movie-admin-search a {
        flex: 1 1 calc(50% - 5px) !important;
        min-width: 0 !important;
        height: 46px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        text-align: center;
        box-sizing: border-box;
        white-space: nowrap;
    }
}
</style>

@endsection
