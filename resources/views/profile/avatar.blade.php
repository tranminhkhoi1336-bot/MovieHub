
@extends('layouts.main')

@section('content')

<style>
.mh-avatar-page {
    max-width: 600px;
    margin: 45px auto;
    padding: 15px;
    box-sizing: border-box;
}

.mh-avatar-card {
    background: #2d3748;
    border-radius: 16px;
    padding: 30px;
    color: #ffffff;
    text-align: center;
}

.mh-avatar-title {
    color: #ff914d;
    font-size: 27px;
    font-weight: bold;
    margin-bottom: 30px;
}

.mh-avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ff914d;
    margin: 0 auto 15px;
    display: block;
}

.mh-avatar-name {
    font-size: 19px;
    margin-bottom: 25px;
}

.mh-avatar-label {
    display: block;
    background: #1b283b;
    border: 2px dashed #64748b;
    border-radius: 12px;
    padding: 25px 12px;
    cursor: pointer;
    margin-bottom: 15px;
    color: #ffffff;
}

.mh-avatar-label:hover {
    border-color: #ff914d;
}

.mh-avatar-label input {
    display: none;
}

.mh-avatar-help {
    color: #cbd5e1;
    font-size: 13px;
    margin: 15px 0;
}

.mh-avatar-submit {
    background: #ff914d;
    color: #111827;
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 9px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.mh-avatar-submit:hover {
    background: #ffad73;
}

.mh-avatar-message {
    margin: 15px 0;
    line-height: 1.6;
}

.mh-avatar-back {
    display: inline-block;
    margin-top: 22px;
    color: #ff914d;
    text-decoration: none;
}

@media (max-width: 600px) {
    .mh-avatar-page {
        margin: 22px auto;
        padding: 12px;
    }

    .mh-avatar-card {
        padding: 22px 15px;
    }

    .mh-avatar-title {
        font-size: 22px;
    }

    .mh-avatar-preview {
        width: 100px;
        height: 100px;
    }
}
</style>

<div class="mh-avatar-page">

    <div class="mh-avatar-card">

        <h1 class="mh-avatar-title">
            THAY ĐỔI ẢNH ĐẠI DIỆN
        </h1>

        @if(session('success'))
            <div class="mh-avatar-message"
                 style="color:#4ade80;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mh-avatar-message"
                 style="color:#f87171;">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- ANH DAI DIEN HIEN TAI -->
        <img
            id="avatarPreview"
            class="mh-avatar-preview"
            src="{{ Auth::user()->avatar
                ? asset(Auth::user()->avatar)
                : asset('img/avatar.jpg') }}"
            alt="Ảnh đại diện"
        >

        <p class="mh-avatar-name">
            {{ Auth::user()->name }}
        </p>

        <!-- FORM UPLOAD -->
        <form
            action="{{ route('profile.avatar.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <label class="mh-avatar-label">
                <span style="font-size:28px;">
                    📷
                </span>

                <br>

                <span>
                    Chọn ảnh từ thiết bị
                </span>

                <input
                    type="file"
                    name="avatar"
                    id="avatarInput"
                    accept="image/jpeg,image/png,image/webp"
                    onchange="previewAvatar(this)"
                    required
                >
            </label>

            <p class="mh-avatar-help">
                Hỗ trợ JPG, PNG, WEBP.
                Dung lượng tối đa 2MB.
            </p>

            <button
                type="submit"
                class="mh-avatar-submit"
            >
                LƯU ẢNH ĐẠI DIỆN
            </button>

        </form>

        <a href="{{ url('/') }}"
           class="mh-avatar-back">
            ← Quay lại MovieHub
        </a>

    </div>
</div>

<script>
function previewAvatar(input) {
    if (!input.files || !input.files[0]) {
        return;
    }

    var file = input.files[0];

    var validTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    if (!validTypes.includes(file.type)) {
        alert('Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP.');
        input.value = '';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        alert('Ảnh không được vượt quá 2MB.');
        input.value = '';
        return;
    }

    var reader = new FileReader();

    reader.onload = function(event) {
        document.getElementById(
            'avatarPreview'
        ).src = event.target.result;
    };

    reader.readAsDataURL(file);
}
</script>

@endsection
