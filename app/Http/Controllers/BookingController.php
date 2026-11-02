<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Hiển thị form đặt vé
   

public function create()
{
    $showtimes = Showtime::with([
        'movie',
        'bookings' => function ($query) {
            $query->whereIn('status', [
                'pending',
                'confirmed'
            ]);
        }
    ])
    ->where('status', 'scheduled')
    ->where('starts_at', '>', now())
    ->orderBy('starts_at', 'asc')
    ->get();

    foreach ($showtimes as $showtime) {

        $occupiedSeats = [];
        $hasUnassignedSeats = false;

        foreach ($showtime->bookings as $booking) {

            $codes = $booking->seat_codes;

            // Kiểm tra đơn cũ chưa có mã ghế
            if (!is_array($codes) ||
                count($codes) !== (int) $booking->quantity) {
                $hasUnassignedSeats = true;
                continue;
            }

            foreach ($codes as $code) {
                $occupiedSeats[] = $code;
            }
        }

        // Danh sách ghế đã được đặt
        $showtime->occupied_seats = array_values(
            array_unique($occupiedSeats)
        );

        // Tính số ghế còn lại
        $reserved = $showtime->bookings->sum('quantity');

        $showtime->remaining_seats = max(
            0,
            (int) $showtime->total_seats - $reserved
        );

        $showtime->has_unassigned_seats = $hasUnassignedSeats;
    }

    // Chỉ cho chọn ghế ở suất chiếu còn chỗ,
    // không có đơn giữ ghế chưa xác định vị trí
    $showtimes = $showtimes->filter(function ($showtime) {
        return $showtime->remaining_seats > 0
            && !$showtime->has_unassigned_seats;
    })->values();

    return view('bookings.create', compact('showtimes'));
}
public function ticket($id)
{
    $booking = \App\Booking::with(['showtime.movie'])
        ->where('user_id', auth()->id())
        ->where('status', 'confirmed')
        ->findOrFail($id);

    return view('bookings.ticket', compact('booking'));
}




    // Xử lý đặt vé

public function store(Request $request)
{
    
$data = $request->validate([
    'showtime_id' => 'required|integer|exists:showtimes,id',
    'seat_codes' => 'required|array|min:1|max:50',
    'seat_codes.*' => [
        'required',
        'string',
        

'regex:/^[A-Z](10|[1-9])$/',


    ],
]);


    $selectedSeats = array_values($data['seat_codes']);

    // Không cho gửi trùng vị trí trong cùng một đơn
    if (count($selectedSeats) !== count(array_unique($selectedSeats))) {
        throw ValidationException::withMessages([
            'seat_codes' => 'Bạn đã chọn trùng vị trí ghế.'
        ]);
    }

    $booking = DB::transaction(function () use ($data, $selectedSeats) {

        // Khóa suất chiếu trong lúc xử lý đơn
        $showtime = Showtime::where('id', $data['showtime_id'])
            ->lockForUpdate()
            ->firstOrFail();

        // Kiểm tra suất chiếu còn hợp lệ
        if ($showtime->status !== 'scheduled' ||
            $showtime->starts_at->lte(now())) {

            throw ValidationException::withMessages([
                'showtime_id' => 'Suất chiếu không còn nhận đặt vé.'
            ]);
        }

        $totalSeats = (int) $showtime->total_seats;

        // Sơ đồ sử dụng tối đa 26 hàng, mỗi hàng 10 ghế
        if ($totalSeats < 1 || $totalSeats > 260) {
            throw ValidationException::withMessages([
                'showtime_id' => 'Số ghế của suất chiếu không hợp lệ.'
            ]);
        }

        // Tạo danh sách các vị trí ghế hợp lệ
        $validSeats = [];

        for ($i = 0; $i < $totalSeats; $i++) {
            $row = chr(65 + intdiv($i, 10));
            $number = ($i % 10) + 1;

            $validSeats[] = $row . $number;
        }

        // Kiểm tra các vị trí khách lựa chọn
        foreach ($selectedSeats as $seat) {
            if (!in_array($seat, $validSeats, true)) {
                throw ValidationException::withMessages([
                    'seat_codes' => 'Vị trí ghế không hợp lệ.'
                ]);
            }
        }

        // Lấy các đơn đang giữ ghế
        $existingBookings = Booking::where(
                'showtime_id', $showtime->id
            )
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $occupiedSeats = [];
        $reservedQuantity = 0;

        foreach ($existingBookings as $existing) {

            $codes = $existing->seat_codes;

            // Không đặt thêm nếu còn đơn cũ chưa gán ghế
            if (!is_array($codes) ||
                count($codes) !== (int) $existing->quantity) {

                throw ValidationException::withMessages([
                    'seat_codes' => 'Suất chiếu còn đơn chưa xác định vị trí ghế.'
                ]);
            }

            $reservedQuantity += (int) $existing->quantity;

            foreach ($codes as $code) {
                $occupiedSeats[] = $code;
            }
        }

        // Kiểm tra tổng số ghế còn lại
        if (count($selectedSeats) > $totalSeats - $reservedQuantity) {
            throw ValidationException::withMessages([
                'seat_codes' => 'Không đủ ghế trống.'
            ]);
        }

        // Không cho đặt trùng ghế đã có người giữ
        foreach ($selectedSeats as $seat) {
            if (in_array($seat, $occupiedSeats, true)) {
                throw ValidationException::withMessages([
                    'seat_codes' => 'Ghế ' . $seat . ' đã được đặt. Vui lòng chọn ghế khác.'
                ]);
            }
        }

        // Tính tiền từ giá vé trong MySQL
        $quantity = count($selectedSeats);
        $totalPrice = round($showtime->price * $quantity, 2);

        // Lưu đơn cùng danh sách vị trí ghế
        return Booking::create([
            'user_id' => auth()->id(),
            'showtime_id' => $showtime->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
'seat_codes' => $selectedSeats,
'expires_at' => null,
        ]);
    });

    
       
return redirect()
    ->route('customer.bookings.payment', [
        'id' => $booking->id
    ]);

}


public function payment($id)
{
    $booking = Booking::with('showtime.movie')
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    // Chi hien thi thanh toan cho don pending
    if ($booking->status !== 'pending') {
        return redirect()
            ->route('customer.bookings.history');
    }



    // Khong thanh toan khi suat chieu da bat dau
    if (!$booking->showtime ||
        $booking->showtime->starts_at->lte(now())) {
        return redirect()
            ->route('customer.bookings.history')
            ->with(
                'error',
                'Suat chieu da bat dau. Vui long lien he nhan vien.'
            );
    }

    $bankId = config('services.vietqr.bank_id');
    $accountNo = config('services.vietqr.account_no');
    $accountName = config('services.vietqr.account_name');

    $amount = (int) round($booking->total_price);
    $paymentContent = 'MOVIEHUB' . $booking->id;

    $qrUrl = null;

    if ($bankId && $accountNo && $accountName && $amount > 0) {
        $params = http_build_query([
            'amount' => $amount,
            'addInfo' => $paymentContent,
            'accountName' => $accountName,
        ], '', '&', PHP_QUERY_RFC3986);

        $qrUrl = 'https://img.vietqr.io/image/'
            . rawurlencode($bankId)
            . '-'
            . rawurlencode($accountNo)
            . '-compact2.svg?'
            . $params;
    }

    return view('bookings.payment', compact(
        'booking',
        'bankId',
        'accountNo',
        'accountName',
        'amount',
        'paymentContent',
        'qrUrl'
    ));
}

    
public function history()
{
    $bookings = Booking::with('showtime.movie')
        ->where('user_id', auth()->id())
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('bookings.history', compact('bookings'));
}

public function ticketLookup(Request $request)
{
    $ticketId = trim(
        (string) $request->query('ticket_id', '')
    );

    $booking = null;
    $error = null;

    if ($ticketId !== '') {

        if (!ctype_digit($ticketId) ||
            (int) $ticketId < 1) {

            $error = 'Mã vé không hợp lệ.';

        } else {

            $booking = Booking::with([
                'user',
                'showtime.movie'
            ])->find((int) $ticketId);

            if (!$booking) {
                $error = 'Không tìm thấy vé trong hệ thống.';
            }
        }
    }

    return view(
        'admin.bookings.lookup',
        compact('ticketId', 'booking', 'error')
    );
}

}
