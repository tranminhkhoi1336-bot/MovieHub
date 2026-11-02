<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
public function index()
{
    $bookings = Booking::with([
        'user',
        'showtime.movie'
    ])
    ->orderBy('id', 'desc')
    ->paginate(10);

    return view('admin.bookings.index', compact('bookings'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    


public function create()
{
    //
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    

public function updateStatus(Request $request, $id)
{
    $data = $request->validate([
        'status' => 'required|in:cancelled',
    ]);

    // Chi cho huy don chua thanh toan
    $updated = Booking::where('id', $id)
        ->where('status', 'pending')
        ->where('payment_status', 'unpaid')
        ->update([
            'status' => 'cancelled'
        ]);

    if ($updated === 0) {
        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'error',
                'Don khong hop le hoac da duoc xu ly.'
            );
    }

    return redirect()
        ->route('admin.bookings.index')
        ->with(
            'success',
            'Da huy don dat ve.'
        );
}

public function paymentForm($id)
{
    $booking = Booking::with([
        'user',
        'showtime.movie'
    ])->findOrFail($id);

    if ($booking->status !== 'pending' ||
        $booking->payment_status !== 'unpaid') {
        return redirect()
            ->route('admin.bookings.index')
            ->with('error', 'Don khong cho xac minh.');
    }



    return view(
        'admin.bookings.verify-payment',
        compact('booking')
    );
}

public function confirmPayment(Request $request, $id)
{
    $data = $request->validate([
        'payment_reference' => [
            'required',
            'string',
            'max:100',
            'unique:bookings,payment_reference'
        ],
        'paid_amount' => 'required|integer|min:1',
        'bank_verified' => 'required|accepted'
    ]);

    DB::transaction(function () use ($id, $data) {

        $booking = Booking::where('id', $id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($booking->status !== 'pending' ||
            $booking->payment_status !== 'unpaid') {
            throw ValidationException::withMessages([
                'payment_reference' =>
                    'Don da duoc xu ly.'
            ]);
        }

if ($booking->expires_at &&
    $booking->expires_at->lte(now())) {

    throw ValidationException::withMessages([
        'payment_reference' =>
            'Don dat ve da het han 10 phut. ' .
            'Khong the xac nhan thanh toan. ' .
            'Neu khach da chuyen khoan, ' .
            'vui long kiem tra va xu ly rieng.'
    ]);
}

        if (!$booking->showtime ||
            $booking->showtime->starts_at->lte(now())) {
            throw ValidationException::withMessages([
                'payment_reference' =>
                    'Suat chieu da bat dau. Can xu ly rieng.'
            ]);
        }

        $expectedAmount = (int) round(
            (float) $booking->total_price
        );

        if ((int) $data['paid_amount'] !== $expectedAmount) {
            throw ValidationException::withMessages([
                'paid_amount' =>
                    'So tien nhan duoc khong khop tong don.'
            ]);
        }

        // Chi thuc hien sau khi Admin da doi soat
        // giao dich tren tai khoan ngan hang.
        $booking->payment_status = 'verified';
        $booking->payment_reference =
            trim($data['payment_reference']);
        $booking->payment_verified_at = now();
        $booking->payment_verified_by = auth()->id();

        // Xac nhan ve sau khi xac minh thanh toan
        $booking->status = 'confirmed';

        $booking->save();
    });

    return redirect()
        ->route('admin.bookings.index')
        ->with(
            'success',
            'Da xac minh thanh toan va xac nhan ve.'
        );
}

public function verifyTicket($id)
{
    $booking = \App\Booking::with('showtime.movie')
        ->findOrFail($id);

    return view('admin.bookings.verify-ticket',
        compact('booking'));
}

public function markTicketUsed($id)
{
    
$booking = \App\Booking::with('showtime')->findOrFail($id);

// Kiểm tra suất chiếu có tồn tại
if (!$booking->showtime || !$booking->showtime->starts_at) {
    return back()->with(
        'error',
        'Không tìm thấy thông tin suất chiếu.'
    );
}

// Xác định thời gian được phép kiểm vé
$startsAt = $booking->showtime->starts_at;


$openTime = $startsAt->copy()->subMinutes(30);

$currentTime = now();

// Chi chan khi chua den gio duoc phep kiem ve
if ($currentTime->lt($openTime)) {

    return back()->with(
        'error',
        'Chua den gio kiem ve. Vui long quay lai sau.'
    );
}

// Khong gioi han thoi gian ket thuc kiem ve
// Khach den tre van duoc su dung ve hop le


    $updated = \App\Booking::where('id', $id)
        ->where('status', 'confirmed')
        ->whereNull('used_at')
        ->update([
            'used_at' => now()
        ]);

    $url = \Illuminate\Support\Facades\URL::signedRoute(
        'admin.tickets.verify',
        ['id' => $id]
    );

    if ($updated === 1) {
        return redirect($url)->with(
            'success',
            'Xác nhận vé đã sử dụng thành công!'
        );
    }

    return redirect($url)->with(
        'error',
        'Vé đã sử dụng hoặc không hợp lệ.'
    );
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
