
@extends('layouts.main')

@section('content')

<div style="max-width:800px; margin:50px auto; padding:20px; min-height:500px;">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:25px;">
        CHỈNH SỬA THÔNG TIN PHIM
    </h1>

    @if ($errors->any())
        <div style="background:#7f1d1d; padding:15px; border-radius:8px; margin-bottom:20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form 
        enctype="multipart/form-data"
        action="{{ route('admin.movies.update', $movie->id) }}"
          method="POST"
          style="background:#2d3748; padding:30px; border-radius:12px;">

        @csrf
        @method('PUT')

        <label>Tên phim *</label>
        <input type="text" name="title" required
               value="{{ old('title', $movie->title) }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Thể loại</label>
        <input type="text" name="genre"
               value="{{ old('genre', $movie->genre) }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Mô tả phim</label>
        <textarea name="description" rows="4"
                  style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">{{ old('description', $movie->description) }}</textarea>

        <label>Thời lượng (phút)</label>
        <input type="number" name="duration" min="1"
               value="{{ old('duration', $movie->duration) }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Ngày phát hành</label>
        <input type="date" name="release_date"
               value="{{ old('release_date', $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y-m-d') : '') }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Đường dẫn poster (URL)</label>
        


        <input type="url" name="poster"
               value="{{ old('poster', $movie->poster) }}"
               style="width:100%; padding:12px; 
               margin:10px 0 20px; color:#111827; border-radius:6px;">
<div style="margin-top:20px; margin-bottom:20px;">

    <label style="display:block;
                  margin-bottom:10px;
                  color:white;">
        Tải poster từ máy tính
    </label>

    <input
        type="file"
        name="poster_file"
        accept="image/jpeg,image/png,image/webp"
        style="width:100%;
               padding:15px;
               background:white;
               color:#111827;
               border-radius:8px;">

    <p style="color:#cbd5e1;
              font-size:14px;
              margin-top:8px;">
        Hỗ trợ JPG, PNG, WEBP.
        Dung lượng tối đa 2MB.
        Để trống nếu muốn giữ poster hiện tại.
    </p>

</div>
        <label>Trạng thái phim *</label>
        <select name="status" required
                style="width:100%; padding:12px; margin:10px 0 25px; color:#111827; border-radius:6px;">

            <option value="coming_soon"
                {{ old('status', $movie->status) == 'coming_soon' ? 'selected' : '' }}>
                Sắp chiếu
            </option>

            <option value="now_showing"
                {{ old('status', $movie->status) == 'now_showing' ? 'selected' : '' }}>
                Đang chiếu
            </option>

        </select>

        <div style="display:flex; gap:20px; align-items:center;">

            <button type="submit"
                    style="background:#ff914d; color:#111827; padding:12px 25px; border-radius:8px; font-weight:bold; cursor:pointer;">
                Lưu thay đổi
            </button>

            <a href="{{ route('admin.movies.index') }}"
               style="color:#cbd5e1; text-decoration:none;">
                Hủy
            </a>

        </div>

    </form>

</div>

@endsection
