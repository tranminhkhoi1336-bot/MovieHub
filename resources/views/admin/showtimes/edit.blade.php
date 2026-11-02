
@extends('layouts.main')

@section('content')

<div style="max-width:800px; margin:50px auto; padding:20px; min-height:500px;">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:25px;">
        CHỈNH SỬA SUẤT CHIẾU
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Cập nhật thông tin lịch chiếu phim trong hệ thống MovieHub.
    </p>

    @if ($errors->any())
        <div style="background:#7f1d1d; color:white; padding:15px;
                    border-radius:8px; margin-bottom:20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.showtimes.update', $showtime->id) }}"
          method="POST"
          style="background:#2d3748; padding:30px; border-radius:12px;">

        @csrf
        @method('PUT')

        <label>Chọn phim *</label>

        <select name="movie_id" required
                style="width:100%; padding:12px; margin:10px 0 20px;
                       color:#111827; background:white; border-radius:6px;">

            @foreach($movies as $movie)
                <option value="{{ $movie->id }}"
                    {{ old('movie_id', $showtime->movie_id) == $movie->id ? 'selected' : '' }}>
                    {{ $movie->title }}
                </option>
            @endforeach

        </select>

        <label>Ngày giờ chiếu *</label>

        <input type="datetime-local"
               name="starts_at"
               required
               value="{{ old('starts_at', $showtime->starts_at ? $showtime->starts_at->format('Y-m-d\TH:i') : '') }}"
               style="width:100%; padding:12px; margin:10px 0 20px;
                      color:#111827; background:white; border-radius:6px;">

        <label>Giá vé (VNĐ) *</label>

        <input type="number"
               name="price"
               min="1"
               step="1"
               required
               value="{{ old('price', $showtime->price) }}"
               style="width:100%; padding:12px; margin:10px 0 20px;
                      color:#111827; background:white; border-radius:6px;">

        <label>Tổng số ghế *</label>

        <input type="number"
               name="total_seats"
               min="1"
               required
               value="{{ old('total_seats', $showtime->total_seats) }}"
               style="width:100%; padding:12px; margin:10px 0 20px;
                      color:#111827; background:white; border-radius:6px;">

        <label>Trạng thái suất chiếu *</label>

        <select name="status" required
                style="width:100%; padding:12px; margin:10px 0 25px;
                       color:#111827; background:white; border-radius:6px;">

            <option value="scheduled"
                {{ old('status', $showtime->status) == 'scheduled' ? 'selected' : '' }}>
                Đã lên lịch
            </option>

            <option value="cancelled"
                {{ old('status', $showtime->status) == 'cancelled' ? 'selected' : '' }}>
                Đã hủy
            </option>

        </select>

        <div style="display:flex; gap:20px; align-items:center;">

            <button type="submit"
                    style="background:#ff914d; color:#111827;
                           padding:12px 25px; border-radius:8px;
                           font-weight:bold; cursor:pointer;">
                Lưu thay đổi
            </button>

            <a href="{{ route('admin.showtimes.index') }}"
               style="color:#cbd5e1; text-decoration:none;">
                Hủy
            </a>

        </div>

    </form>

</div>

@endsection
