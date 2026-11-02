
@extends('layouts.main')

@section('content')

<style>
    .booking-container {
        max-width: 950px;
        margin: 50px auto;
        padding: 20px;
        min-height: 500px;
    }

    .booking-card {
        background: #2d3748;
        padding: 30px;
        border-radius: 12px;
    }

    .booking-select {
        width: 100%;
        padding: 14px;
        margin: 10px 0 25px;
        border-radius: 6px;
        background: white;
        color: #111827;
    }

    .cinema-screen {
        background: #475569;
        text-align: center;
        padding: 12px;
        border-radius: 6px;
        margin: 30px auto;
        max-width: 650px;
        font-weight: bold;
        color: white;
    }

    .seat-grid {
        display: grid;
        grid-template-columns: repeat(10, minmax(0, 1fr));
        gap: 7px;
        max-width: 650px;
        margin: 20px auto;
    }

    .seat {
        min-width: 0;
        padding: 12px 0;
        border: none;
        border-radius: 6px;
        background: #475569;
        color: white;
        cursor: pointer;
        font-size: 13px;
    }

    .seat.selected {
        background: #ff914d;
        color: #111827;
        font-weight: bold;
    }

    .seat.occupied {
        background: #dc2626;
        color: white;
        cursor: not-allowed;
    }

    .seat:focus-visible {
        outline: 3px solid white;
        outline-offset: 2px;
    }

    .seat-legend {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin: 25px 0;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .legend-color {
        width: 18px;
        height: 18px;
        border-radius: 4px;
    }

    .booking-summary {
        background: #1b2230;
        padding: 20px;
        border-radius: 10px;
        margin-top: 25px;
        line-height: 2;
    }

    .booking-button {
        background: #ff914d;
        color: #111827;
        padding: 14px 25px;
        border: none;
        border-radius: 8px;
        margin-top: 25px;
        font-weight: bold;
        cursor: pointer;
    }

    .booking-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
/* ===== MOVIEHUB - GIAO DIEN CHON GHE MOI ===== */

.booking-container {
    max-width: 1150px;
    margin: 35px auto 75px;
    padding: 20px;
}

.booking-card {
    background: linear-gradient(145deg, #2b3950, #202b3e);
    border: 1px solid #43536c;
    border-radius: 22px;
    padding: 35px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
}

.booking-card > label {
    display: block;
    font-weight: 700;
    font-size: 16px;
}

.booking-select {
    border: 2px solid #586780;
    border-radius: 12px;
    font-size: 15px;
    transition: border-color 0.2s;
}

.booking-select:focus {
    outline: none;
    border-color: #ff914d;
}

/* KHU VUC SO DO GHE */
#seatSection {
    margin-top: 25px;
    padding: 30px 22px;
    background: #182436;
    border: 1px solid #3d4d65;
    border-radius: 20px;
}

#seatSection > h2 {
    color: white;
    text-align: center;
    margin-bottom: 25px;
    letter-spacing: 1px;
}

/* MAN HINH CHIEU */
.cinema-screen {
    max-width: 800px;
    padding: 17px;
    margin: 25px auto 45px;
    background: linear-gradient(
        180deg,
        #e2e8f0 0%,
        #94a3b8 100%
    );
    color: #162033;
    border-radius: 50% 50% 12px 12px / 35% 35% 12px 12px;
    font-size: 15px;
    font-weight: 900;
    letter-spacing: 3px;
    box-shadow: 0 15px 35px rgba(148, 163, 184, 0.17);
}

/* SO DO GHE */
.mh-seat-scroll {
    overflow-x: auto;
    padding: 5px 3px 16px;
}

.seat-grid {
    display: grid;
    grid-template-columns: repeat(10, minmax(0, 1fr));
    gap: 9px;
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
}

/* GHE TRONG */
.seat {
    min-width: 0;
    min-height: 45px;
    padding: 10px 2px;
    background: #425570;
    color: white;
    border: 1px solid #61728c;
    border-bottom: 4px solid #26354b;
    border-radius: 11px 11px 7px 7px;
    font-size: 13px;
    font-weight: 600;
    transition: transform 0.2s, background 0.2s;
}

.seat:hover:not(.occupied):not(.selected) {
    background: #627997;
    transform: translateY(-3px);
}

/* GHE DANG CHON */
.seat.selected {
    background: #ff914d;
    color: #111827;
    border-color: #ffc096;
    border-bottom-color: #ce6127;
    font-weight: 800;
}

.seat.selected:hover {
    background: #ffaa74;
}

/* GHE DA DAT */
.seat.occupied {
    background: #b91c1c;
    color: white;
    border-color: #dc2626;
    border-bottom-color: #7f1d1d;
    cursor: not-allowed;
    opacity: 0.85;
}

/* CHU THICH */
.seat-legend {
    display: flex;
    justify-content: center;
    gap: 22px;
    flex-wrap: wrap;
    margin: 30px 0;
    color: #cbd5e1;
}

.legend-color {
    border-radius: 5px;
    border: 1px solid rgba(255,255,255,0.15);
}

/* BANG TOM TAT DAT VE */
.booking-summary {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
    background: #101a2b;
    padding: 22px;
    border: 1px solid #40516a;
    border-radius: 15px;
    line-height: 1.6;
}

.booking-summary p {
    margin: 0;
    padding: 12px;
    background: #26364c;
    border-radius: 9px;
    color: #cbd5e1;
}

.booking-summary strong {
    color: white;
    font-weight: 800;
}

.booking-summary p:last-child {
    grid-column: 1 / -1;
    background: #352b32;
    border: 1px solid rgba(255,145,77,0.35);
    color: #ff914d;
    font-size: 20px;
}

.booking-summary p:last-child strong {
    color: #ff914d;
}

/* NUT XAC NHAN */
.booking-button {
    display: block;
    width: 100%;
    padding: 17px 25px;
    background: #ff914d;
    color: #111827;
    border: 0;
    border-radius: 11px;
    font-size: 16px;
    font-weight: 900;
    transition: background 0.2s, transform 0.2s;
}

.booking-button:hover:not(:disabled) {
    background: #ffad79;
    transform: translateY(-2px);
}

.booking-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* GIAO DIEN DIEN THOAI */
@media (max-width: 720px) {
    .booking-container {
        padding: 12px;
        margin-top: 20px;
    }

    .booking-card {
        padding: 20px 14px;
    }

    #seatSection {
        padding: 20px 12px;
    }

    .seat-grid {
        min-width: 600px;
    }

    .booking-summary {
        grid-template-columns: 1fr;
        padding: 14px;
    }

    .booking-summary p:last-child {
        grid-column: 1;
    }

    .seat-legend {
        gap: 12px;
        font-size: 13px;
    }
}

/* Responsive sơ đồ ghế trên điện thoại */
@media (max-width: 640px) {

    .mh-mobile-seat-scroll {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        padding: 5px 0 12px;
        box-sizing: border-box;
    }

    .mh-mobile-seat-scroll #seatGrid {
        width: max-content !important;
        min-width: max-content;
        max-width: none !important;
        margin-left: auto;
        margin-right: auto;
    }
}

</style>

<div class="booking-container">

    <h1 style="font-size:30px; font-weight:bold; margin-bottom:20px;">
        ĐẶT VÉ XEM PHIM
    </h1>

    <p style="color:#cbd5e1; margin-bottom:25px;">
        Chọn suất chiếu và vị trí ghế bạn muốn đặt.
    </p>

    @if(session('success'))
        <div style="background:#166534; padding:15px;
                    border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background:#991b1b; padding:15px;
                    border-radius:8px; margin-bottom:20px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form id="bookingForm"
          action="{{ route('customer.bookings.store') }}"
          method="POST"
          class="booking-card">

        @csrf

        <label for="showtimeSelect">Chọn suất chiếu *</label>

        
<select name="showtime_id"
        id="showtimeSelect"
        class="booking-select"
        style="color:#111827; background-color:#ffffff;"
        required>


            
<option value="" style="color:#111827; background-color:#ffffff;">
    -- Chọn suất chiếu --
</option>


            @foreach($showtimes as $showtime)

                <option
                
                    style="color:#111827; background-color:#ffffff;"

                    value="{{ $showtime->id }}"
                    data-price="{{ $showtime->price }}"
                    data-total-seats="{{ $showtime->total_seats }}"
                    data-occupied='@json($showtime->occupied_seats)'
                   
                    {{ old('showtime_id', request()->query('showtime_id')) == $showtime->id ? 'selected' : '' }}>


                    {{ optional($showtime->movie)->title }}
                    -
                    {{ $showtime->starts_at->format('d/m/Y H:i') }}
                    -
                    {{ number_format($showtime->price, 0, ',', '.') }} đ/vé
                    -
                    Còn {{ $showtime->remaining_seats }} ghế

                </option>

            @endforeach

        </select>

        <div id="seatSection" style="display:none;">

            <h2 style="font-size:22px; font-weight:bold;">
                CHỌN VỊ TRÍ GHẾ
            </h2>

            <div class="cinema-screen">
                MÀN HÌNH CHIẾU
            </div>

            
            
<div class="mh-seat-scroll mh-mobile-seat-scroll">
    <div id="seatGrid" class="seat-grid"></div>
</div>


            <div class="seat-legend">

                <div class="legend-item">
                    <span class="legend-color"
                          style="background:#475569;"></span>
                    Ghế trống
                </div>

                <div class="legend-item">
                    <span class="legend-color"
                          style="background:#ff914d;"></span>
                    Đang chọn
                </div>

                <div class="legend-item">
                    <span class="legend-color"
                          style="background:#dc2626;"></span>
                    Đã đặt
                </div>

            </div>

            <div class="booking-summary">

                <p>
                    Ghế đã chọn:
                    <strong id="selectedSeatsText">Chưa chọn</strong>
                </p>

                <p>
                    Số lượng vé:
                    <strong id="quantityText">0</strong>
                </p>

                <p>
                    Giá mỗi vé:
                    <strong id="priceText">0 đ</strong>
                </p>

                <p style="color:#ff914d; font-size:20px;">
                    Tổng tiền:
                    <strong id="totalPriceText">0 đ</strong>
                </p>

            </div>

        </div>

        <div id="selectedSeatsInputs"></div>

        @if($showtimes->isEmpty())
            <p style="color:#fbbf24;">
                Hiện không có suất chiếu còn chỗ hợp lệ để đặt vé.
            </p>
        @endif

        <p id="seatError"
           style="color:#f87171; margin-top:15px;"
           role="alert"></p>

        <noscript>
            <p style="color:#f87171;">
                Vui lòng bật JavaScript để sử dụng chức năng chọn ghế.
            </p>
        </noscript>

        <button type="submit"
                id="bookingSubmit"
                class="booking-button"
                disabled>
            Xác nhận đặt vé
        </button>

    </form>

    <a href="{{ route('customer.bookings.history') }}"
       style="display:inline-block; margin-top:30px;
              color:#ff914d; font-weight:bold; text-decoration:none;">
        → Xem lịch sử đặt vé của tôi
    </a>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const showtimeSelect = document.getElementById('showtimeSelect');
    const seatSection = document.getElementById('seatSection');
    const seatGrid = document.getElementById('seatGrid');
    const inputsContainer = document.getElementById('selectedSeatsInputs');
    const form = document.getElementById('bookingForm');
    const submitButton = document.getElementById('bookingSubmit');

    const selectedSeatsText = document.getElementById('selectedSeatsText');
    const quantityText = document.getElementById('quantityText');
    const priceText = document.getElementById('priceText');
    const totalPriceText = document.getElementById('totalPriceText');
    const seatError = document.getElementById('seatError');

    let selectedSeats = new Set();
    let currentPrice = 0;

    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
    }

    function updateSummary() {

        const seats = Array.from(selectedSeats).sort();

        selectedSeatsText.textContent = seats.length
            ? seats.join(', ')
            : 'Chưa chọn';

        quantityText.textContent = seats.length;
        priceText.textContent = formatMoney(currentPrice);

        totalPriceText.textContent = formatMoney(
            currentPrice * seats.length
        );

        inputsContainer.replaceChildren();

        seats.forEach(function (seat) {

            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = 'seat_codes[]';
            input.value = seat;

            inputsContainer.appendChild(input);
        });

        submitButton.disabled = seats.length === 0;
    }

    function renderSeats() {

        selectedSeats.clear();
        seatGrid.replaceChildren();
        seatError.textContent = '';

        const option = showtimeSelect.selectedOptions[0];

        if (!option || !option.value) {
            seatSection.style.display = 'none';
            currentPrice = 0;
            updateSummary();
            return;
        }

        const totalSeats = Number(option.dataset.totalSeats);
        currentPrice = Number(option.dataset.price);

        let occupiedSeats;

        try {
            occupiedSeats = JSON.parse(option.dataset.occupied || '[]');

            if (!Array.isArray(occupiedSeats)) {
                throw new Error('Dữ liệu ghế không hợp lệ');
            }
        } catch (error) {
            seatSection.style.display = 'none';
            seatError.textContent = 'Không đọc được danh sách ghế.';
            currentPrice = 0;
            updateSummary();
            return;
        }

        if (!Number.isInteger(totalSeats) ||
            totalSeats < 1 || totalSeats > 260) {
            seatSection.style.display = 'none';
            seatError.textContent = 'Sơ đồ ghế không hợp lệ.';
            currentPrice = 0;
            updateSummary();
            return;
        }

        seatSection.style.display = 'block';

        const occupied = new Set(occupiedSeats);

        for (let i = 0; i < totalSeats; i++) {

            const row = String.fromCharCode(65 + Math.floor(i / 10));
            const number = (i % 10) + 1;
            const seatCode = row + number;

            const button = document.createElement('button');

            button.type = 'button';
            button.className = 'seat';
            button.textContent = seatCode;

            if (occupied.has(seatCode)) {

                button.classList.add('occupied');
                button.disabled = true;
                button.setAttribute('aria-label', seatCode + ' đã đặt');

            } else {

                button.setAttribute('aria-pressed', 'false');

                button.addEventListener('click', function () {

                    if (selectedSeats.has(seatCode)) {

                        selectedSeats.delete(seatCode);
                        button.classList.remove('selected');
                        button.setAttribute('aria-pressed', 'false');

                    } else {

                        selectedSeats.add(seatCode);
                        button.classList.add('selected');
                        button.setAttribute('aria-pressed', 'true');

                    }

                    seatError.textContent = '';
                    updateSummary();
                });
            }

            seatGrid.appendChild(button);
        }

        updateSummary();
    }

    showtimeSelect.addEventListener('change', renderSeats);

    form.addEventListener('submit', function (event) {

        if (selectedSeats.size === 0) {
            event.preventDefault();
            seatError.textContent = 'Vui lòng chọn ít nhất một ghế.';
            return;
        }

        submitButton.disabled = true;
    });

    renderSeats();
});
</script>

@endsection
