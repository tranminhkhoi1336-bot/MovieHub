
@extends('layouts.main')

@section('content')

<div style="
    max-width:800px;
    margin:60px auto;
    padding:25px;
    min-height:450px;
">

    <div style="
        background:#2d3748;
        padding:35px;
        border-radius:15px;
        color:white;
    ">

        <h1 style="
            color:#ff914d;
            font-size:30px;
            font-weight:bold;
            margin-bottom:15px;
        ">
            TRA CỨU & KIỂM VÉ
        </h1>

        <p style="margin-bottom:25px;">
            Nhập mã vé để kiểm tra thông tin đặt vé
            trên hệ thống MovieHub.
        </p>

        <form method="GET"
              action="{{ route('admin.tickets.lookup') }}">

            <label for="ticket_id">
                Mã vé
            </label>

            <input
                id="ticket_id"
                type="text"
                name="ticket_id"
                value="{{ $ticketId }}"
                placeholder="Ví dụ: 10 hoặc 000012"
                required
                style="
                    display:block;
                    width:100%;
                    padding:15px;
                    margin:12px 0 20px;
                    background:white;
                    color:#111827;
                    border-radius:8px;
                "
            >

            <button type="submit"
                style="
                    background:#ff914d;
                    color:#111827;
                    padding:13px 25px;
                    border-radius:8px;
                    font-weight:bold;
                    cursor:pointer;
                ">
                TRA CỨU VÉ
            </button>

        </form>

<!-- QUET MA QR VE MOVIEHUB -->
<div style="
    margin-top:30px;
    padding:25px;
    background:#192538;
    border:1px solid #475569;
    border-radius:12px;
">

    <h2 style="
        color:#ff914d;
        font-size:23px;
        font-weight:bold;
        margin-bottom:15px;
    ">
        QUÉT MÃ QR VÉ XEM PHIM
    </h2>

    <p style="
        color:#cbd5e1;
        margin-bottom:20px;
    ">
        Sử dụng camera để quét mã QR trên vé điện tử
        hoặc tải ảnh mã QR từ máy tính.
    </p>

    

<style>
.mh-qr-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin: 20px 0;
}
.mh-qr-actions button,
.mh-qr-actions label {
    border: 0;
    padding: 13px 22px;
    border-radius: 9px;
    font-weight: bold;
    cursor: pointer;
}
#mh-start-camera {
    background: #ff914d;
    color: #111827;
}
.mh-qr-upload {
    background: #475569;
    color: white;
}
.mh-qr-placeholder {
    max-width: 480px;
    min-height: 240px;
    margin: 0 auto;
    background: #29364b;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 16px;
    padding: 20px;
    text-align: center;
}
.mh-qr-frame {
    width: 180px;
    height: 140px;
    border: 3px dashed #ff914d;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #ff914d;
    font-size: 55px;
}
</style>

<div class="mh-qr-actions">
    <button type="button" id="mh-start-camera">
        📷 Bật camera
    </button>

    <label for="mh-qr-file" class="mh-qr-upload">
        🖼 Chọn ảnh QR
    </label>

    <input type="file"
           id="mh-qr-file"
           accept="image/*"
           style="display:none;">
</div>

<div id="mh-qr-placeholder" class="mh-qr-placeholder">
    <div class="mh-qr-frame">▣</div>
    <p style="color:#cbd5e1;">
        Đưa mã QR của khách hàng vào vùng quét
    </p>
</div>

<div id="moviehub-qr-reader"
     style="display:none;max-width:480px;margin:auto;
            background:white;color:#111827;border-radius:12px;">
</div>



    <p id="moviehub-qr-message"
       style="
           color:#fbbf24;
           text-align:center;
           margin-top:15px;
       ">
    </p>

</div>

        @if($error)
            <p style="
                color:#f87171;
                margin-top:25px;
            ">
                {{ $error }}
            </p>
        @endif

        @if($booking)

            <div style="
                background:#192538;
                padding:25px;
                border-radius:12px;
                margin-top:30px;
            ">

                <h2 style="
                    color:#ff914d;
                    font-size:22px;
                    margin-bottom:15px;
                ">
                    THÔNG TIN VÉ #{{ $booking->id }}
                </h2>

                <p>
                    Khách hàng:
                    {{ $booking->user->name ?? 'Không xác định' }}
                </p>

                <p>
                    Phim:
                    {{ optional(optional($booking->showtime)->movie)->title ?? 'Không xác định' }}
                </p>

                <p>
                    Ghế:
                    {{ implode(', ', $booking->seat_codes ?? []) }}
                </p>

                <p>
                    Số lượng:
                    {{ $booking->quantity }}
                </p>

                @if($booking->status === 'confirmed')

                    @if($booking->used_at)
                        <p style="color:#f87171;">
                            VÉ ĐÃ SỬ DỤNG
                        </p>
                    @else
                        <p style="color:#4ade80;">
                            VÉ ĐÃ XÁC NHẬN
                        </p>
                    @endif

                    <a href="{{ \Illuminate\Support\Facades\URL::signedRoute(
                        'admin.tickets.verify',
                        ['id' => $booking->id]
                    ) }}"
                       style="
                           display:inline-block;
                           margin-top:20px;
                           padding:12px 20px;
                           border-radius:8px;
                           background:#ff914d;
                           color:#111827;
                           text-decoration:none;
                           font-weight:bold;
                       ">
                        MỞ TRANG KIỂM VÉ
                    </a>

                @else

                    <p style="color:#fbbf24;">
                        Vé chưa được xác nhận
                        hoặc đã bị hủy.
                    </p>

                @endif

            </div>

        @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const message = document.getElementById('moviehub-qr-message');
    const reader = document.getElementById('moviehub-qr-reader');
    const placeholder = document.getElementById('mh-qr-placeholder');
    const cameraBtn = document.getElementById('mh-start-camera');
    const fileInput = document.getElementById('mh-qr-file');

    if (typeof Html5Qrcode === 'undefined') {
        message.textContent = 'Không tải được thư viện quét QR.';
        return;
    }

    const scanner = new Html5Qrcode('moviehub-qr-reader');
    let cameraOn = false;
    let busy = false;
    let processing = false;

    function showPlaceholder() {
        reader.style.display = 'none';
        placeholder.style.display = 'flex';
    }

    async function handleQR(value) {
        if (processing) return;

        let url;

        try {
            url = new URL(value.trim());
        } catch (e) {
            message.textContent = 'Mã QR không hợp lệ.';
            return;
        }

        const validPath =
            /^\/admin\/tickets\/[1-9]\d*\/verify$/.test(url.pathname);

        const validSignature =
            /^[a-f0-9]{64}$/i.test(
                url.searchParams.get('signature') || ''
            );

        if (url.origin !== window.location.origin ||
            !validPath || !validSignature) {
            message.textContent =
                'Mã QR không thuộc hệ thống MovieHub.';
            return;
        }

        processing = true;
        message.textContent = 'Đã quét thành công! Đang mở vé...';

        if (cameraOn) {
            try {
                await scanner.stop();
                cameraOn = false;
            } catch (e) {}
        }

        window.location.assign(url.pathname + url.search);
    }

    cameraBtn.addEventListener('click', async function () {
        if (busy || processing) return;

        busy = true;
        cameraBtn.disabled = true;

        try {
            if (cameraOn) {
                await scanner.stop();
                cameraOn = false;
                cameraBtn.textContent = '📷 Bật camera';
                showPlaceholder();
                message.textContent = 'Đã tắt camera.';
            } else {
                placeholder.style.display = 'none';
                reader.style.display = 'block';

                await scanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: 220 },
                    function (text) {
                        handleQR(text);
                    },
                    function () {}
                );

                cameraOn = true;
                cameraBtn.textContent = '⏹ Tắt camera';
                message.textContent =
                    'Đưa mã QR vào vùng camera.';
            }
        } catch (e) {
            if (!cameraOn) showPlaceholder();

            message.textContent =
                'Không thể thao tác camera. Kiểm tra quyền truy cập.';
        } finally {
            busy = false;
            cameraBtn.disabled = false;
        }
    });

    fileInput.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file || busy || processing) return;

        busy = true;
        cameraBtn.disabled = true;

        try {
            if (cameraOn) {
                await scanner.stop();
                cameraOn = false;
                cameraBtn.textContent = '📷 Bật camera';
            }

            placeholder.style.display = 'none';
            reader.style.display = 'block';

            const result = await scanner.scanFile(file, false);
            await handleQR(result);
        } catch (e) {
            if (!processing) {
                message.textContent =
                    'Không đọc được QR. Vui lòng chọn ảnh rõ hơn.';
            }
        } finally {
            if (!processing) showPlaceholder();
            this.value = '';
            busy = false;
            cameraBtn.disabled = false;
        }
    });
});
</script>



@endsection
