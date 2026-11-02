
@extends('layouts.main')

@section('content')

<div style="max-width:800px; margin:50px auto; padding:20px; min-height:500px;">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:25px;">
        THÊM PHIM MỚI
    </h1>

    @if ($errors->any())
        <div style="background:#7f1d1d; padding:15px; border-radius:8px; margin-bottom:20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    
<form action="{{ route('admin.movies.store') }}"
      method="POST"
      enctype="multipart/form-data"
      style="background:#2d3748; padding:30px; border-radius:12px;">


        @csrf

        <label>Tên phim *</label>
        <input type="text" name="title" required
               value="{{ old('title') }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Thể loại</label>
        <input type="text" name="genre"
               value="{{ old('genre') }}"
               placeholder="Hành động, Phiêu lưu..."
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Mô tả phim</label>
        <textarea name="description" rows="4"
                  style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">{{ old('description') }}</textarea>

        <label>Thời lượng (phút)</label>
        <input type="number" name="duration" min="1"
               value="{{ old('duration') }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        <label>Ngày phát hành</label>
        <input type="date" name="release_date"
               value="{{ old('release_date') }}"
               style="width:100%; padding:12px; margin:10px 0 20px; color:#111827; border-radius:6px;">

        

<!-- TAI POSTER TU MAY TINH -->


<!-- NHAP URL DU PHONG -->

<label style="display:block; margin-bottom:10px;">
    Tải poster từ máy tính hoặc điện thoại
</label>

<input type="file"
       name="poster_file"
       id="poster_file"
       accept="image/jpeg,image/png,image/webp"
       style="width:100%;
              background:#1b283b;
              color:white;
              padding:15px;
              margin-bottom:10px;
              border:2px dashed #ff914d;
              border-radius:8px;">

<p style="color:#cbd5e1; margin-bottom:20px;">
    Hỗ trợ JPG, PNG, WEBP. Tối đa 2MB.
</p>

<label>Hoặc nhập đường dẫn poster (URL)</label>

<input type="url"
       name="poster"
       value="{{ old('poster') }}"
       placeholder="https://example.com/poster.jpg"
       style="width:100%;
              padding:12px;
              margin:10px 0 20px;
              color:#111827;
              border-radius:6px;">

        <label>Trạng thái phim *</label>
        <select name="status" required
                style="width:100%; padding:12px; margin:10px 0 25px; color:#111827; border-radius:6px;">
            <option value="coming_soon"
                {{ old('status') == 'coming_soon' ? 'selected' : '' }}>
                Sắp chiếu
            </option>

            <option value="now_showing"
                {{ old('status') == 'now_showing' ? 'selected' : '' }}>
                Đang chiếu
            </option>
        </select>

        <div style="display:flex; gap:20px; align-items:center;">

            <button type="submit"
                    style="background:#ff914d; color:#111827; padding:12px 25px; border-radius:8px; font-weight:bold; cursor:pointer;">
                Lưu phim
            </button>

            <a href="{{ route('admin.movies.index') }}"
               style="color:#cbd5e1; text-decoration:none;">
                Hủy
            </a>

        </div>

    </form>

</div>

@endsection
