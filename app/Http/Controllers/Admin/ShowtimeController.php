<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Showtime;
use App\Movie;
class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

public function index()
{
    $showtimes = Showtime::with('movie')
        ->orderBy('starts_at', 'desc')
        ->paginate(10);

    return view('admin.showtimes.index', compact('showtimes'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
public function create()
{
    $movies = Movie::orderBy('title', 'asc')->get();

    return view('admin.showtimes.create', compact('movies'));
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
public function store(Request $request)
{
    $data = $request->validate([
        'movie_id' => 'required|integer|exists:movies,id',
        'starts_at' => 'required|date|after:now',
        'price' => 'required|numeric|min:0.01|max:99999999.99',
        'total_seats' => 'required|integer|min:1',
        'status' => 'required|in:scheduled,cancelled',
    ]);

    Showtime::create($data);

    return redirect()
        ->route('admin.showtimes.index')
        ->with('success', 'Thêm suất chiếu thành công!');
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
    $showtime = Showtime::findOrFail($id);

    $movies = Movie::orderBy('title', 'asc')->get();

    return view('admin.showtimes.edit',
        compact('showtime', 'movies'));
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
    $showtime = Showtime::findOrFail($id);

    $data = $request->validate([
        'movie_id' => 'required|integer|exists:movies,id',
        'starts_at' => 'required|date|after:now',
        'price' => 'required|numeric|min:0.01|max:99999999.99',
        'total_seats' => 'required|integer|min:1',
        'status' => 'required|in:scheduled,cancelled',
    ]);

    // Không chỉnh sửa suất chiếu đã có người đặt vé
    if ($showtime->bookings()->exists()) {
        return redirect()
            ->route('admin.showtimes.index')
            ->with('error', 'Không thể chỉnh sửa suất chiếu đã có người đặt vé!');
    }

    $showtime->update($data);

    return redirect()
        ->route('admin.showtimes.index')
        ->with('success', 'Cập nhật suất chiếu thành công!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
public function destroy($id)
{
    $showtime = Showtime::findOrFail($id);

    // Kiểm tra suất chiếu đã có người đặt vé chưa
    if ($showtime->bookings()->exists()) {
        return redirect()
            ->route('admin.showtimes.index')
            ->with('error', 'Không thể xóa suất chiếu đã có người đặt vé!');
    }

    // Xóa suất chiếu nếu chưa có đặt vé
    $showtime->delete();

    return redirect()
        ->route('admin.showtimes.index')
        ->with('success', 'Xóa suất chiếu thành công!');
}

}
