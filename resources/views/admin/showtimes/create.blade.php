
@extends('layouts.main')

@section('content')

<div style="max-width:800px; margin:50px auto; padding:20px; min-height:500px;">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:25px;">
        THÊM SUẤT CHIẾU MỚI
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Nhập thông tin để tạo lịch chiếu phim trong hệ thống MovieHub.
    </p>

    @if ($errors->any())
        <div style="background:#7f1d1d; color:white; padding:15px;
                    border-radius:8px; margin-bottom:20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if ($movies->isEmpty())
        <div style="background:#92400e; padding:15px;
                    border-radius:8px; margin-bottom:20px;">
            Chưa có phim trong cơ sở dữ liệu.
            Vui lòng thêm phim trước khi tạo suất chiếu.
        </div>
    @endif

    <form action="{{ route('admin.showtimes.store') }}"
          method="POST"
          style="background:#2d3748; padding:30px; border-radius:12px;">

        @csrf

        <!-- Chọn phim -->
        <label>Chọn phim *</label>

        <select name="movie_id" required
                style="width:100%; padding:12px; margin:10px 0 20px;
                       color:#111827; background:white; border-radius:6px;">

            <option value="">-- Chọn phim --</option>

            @foreach($movies as $movie)
                <option value="{{ $movie->id }}"
                    {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                    {{ $movie->title }}
                </option>
            @endforeach

        </select>

        <!-- Ngày giờ chiếu -->
        <label>Ngày giờ chiếu *</label>

        <input type="datetime-local"
               name="starts_at"
               required
               value="{{ old('starts_at') }}"
               style="width:100%; padding:12px; margin:10px 0 20px;
                      color:#111827; background:white; border-radius:6px;">

        <!-- Giá vé -->
        <label>Giá vé (VNĐ) *</label>

        <input type="number"
               name="price"
               min="1"
               step="1"
               required
               placeholder="Ví dụ: 75000"
               value="{{ old('price') }}"
               style="width:100%; padding:12px; margin:10px 0 20px;
                      color:#111827; background:white; border-radius:6px;">

        <!-- Tổng số ghế -->
        <label>Tổng số ghế *</label>

        <input type="number"
               name="total_seats"
               min="1"
               required
               value="{{ old('total_seats', 50) }}"
               style="width:100%; padding:12px; margin:10px 0 20px;
                      color:#111827; background:white; border-radius:6px;">

        <!-- Trạng thái -->
        <label>Trạng thái suất chiếu *</label>

        <select name="status" required
                style="width:100%; padding:12px; margin:10px 0 25px;
                       color:#111827; background:white; border-radius:6px;">

            <option value="scheduled"
                {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>
                Đã lên lịch
            </option>

            <option value="cancelled"
                {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                Đã hủy
            </option>

        </select>

        <!-- Nút thao tác -->
        <div style="display:flex; gap:20px; align-items:center;">

            <button type="submit"
                    {{ $movies->isEmpty() ? 'disabled' : '' }}
                    style="background:#ff914d;
                           color:#111827;
                           padding:12px 25px;
                           border-radius:8px;
                           font-weight:bold;
                           cursor:pointer;">
                Lưu suất chiếu
            </button>

            <a href="{{ route('admin.showtimes.index') }}"
               style="color:#cbd5e1; text-decoration:none;">
                Hủy
            </a>

        </div>

    </form>

</div>

@endsection
