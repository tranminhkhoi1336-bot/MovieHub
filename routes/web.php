<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MoviesController@index')->name('movies.index');
Route::get('/movies/{id}', 'MoviesController@show')->name('movies.show');

Route::get('/tv', 'TvController@index')->name('tv.index');
Route::get('/tv/{id}', 'TvController@show')->name('tv.show');

Route::get('/actors', 'ActorsController@index')->name('actors.index');
Route::get('/actors/page/{page?}', 'ActorsController@index');

Route::get('/actors/{id}', 'ActorsController@show')->name('actors.show');



/*
|--------------------------------------------------------------------------
| Authentication Routes - MovieHub
|--------------------------------------------------------------------------
*/

// Các trang dành cho khách chưa đăng nhập
Route::middleware('guest')->group(function () {
    // Đăng ký
    Route::get('/register', 'AuthController@showRegister')
        ->name('register');

    Route::post('/register', 'AuthController@register');

    // Đăng nhập
    Route::get('/login', 'AuthController@showLogin')
        ->name('login');

    Route::post('/login', 'AuthController@login');
});

// Đăng xuất - yêu cầu đã đăng nhập
Route::post('/logout', 'AuthController@logout')
    ->middleware('auth')
    ->name('logout');


Route::get('/admin', function () {

    $movieCount = \App\Movie::count();

    $showtimeCount = \App\Showtime::count();

    $bookingCount = \App\Booking::count();

    $pendingCount = \App\Booking::where(
        'status', 'pending'
    )->count();

    $confirmedCount = \App\Booking::where(
        'status', 'confirmed'
    )->count();

    $cancelledCount = \App\Booking::where(
        'status', 'cancelled'
    )->count();

    $confirmedBookingValue = \App\Booking::where(
        'status', 'confirmed'
    )->sum('total_price');

    return view('admin.dashboard', compact(
        'movieCount',
        'showtimeCount',
        'bookingCount',
        'pendingCount',
        'confirmedCount',
        'cancelledCount',
        'confirmedBookingValue'
    ));

})->middleware(['auth', 'admin'])
  ->name('admin.dashboard');

  
Route::get('/admin/movies', 'Admin\MovieController@index')
    ->middleware(['auth', 'admin'])
    ->name('admin.movies.index');

    
Route::get('/admin/movies/create', 'Admin\MovieController@create')
    ->middleware(['auth', 'admin'])
    ->name('admin.movies.create');

Route::post('/admin/movies', 'Admin\MovieController@store')
    ->middleware(['auth', 'admin'])
    ->name('admin.movies.store');

    
Route::get('/admin/movies/{id}/edit', 'Admin\MovieController@edit')
    ->middleware(['auth', 'admin'])
    ->name('admin.movies.edit');

Route::put('/admin/movies/{id}', 'Admin\MovieController@update')
    ->middleware(['auth', 'admin'])
    ->name('admin.movies.update');

    
Route::delete('/admin/movies/{id}', 'Admin\MovieController@destroy')
    ->middleware(['auth', 'admin'])
    ->name('admin.movies.destroy');

Route::get('/admin/showtimes', 'Admin\ShowtimeController@index')
    ->middleware(['auth', 'admin'])
    ->name('admin.showtimes.index');

    
Route::get('/admin/showtimes/create', 'Admin\ShowtimeController@create')
    ->middleware(['auth', 'admin'])
    ->name('admin.showtimes.create');

Route::post('/admin/showtimes', 'Admin\ShowtimeController@store')
    ->middleware(['auth', 'admin'])
    ->name('admin.showtimes.store');

    
Route::get('/admin/showtimes/{id}/edit', 'Admin\ShowtimeController@edit')
    ->middleware(['auth', 'admin'])
    ->name('admin.showtimes.edit');

Route::put('/admin/showtimes/{id}', 'Admin\ShowtimeController@update')
    ->middleware(['auth', 'admin'])
    ->name('admin.showtimes.update');

    
Route::delete('/admin/showtimes/{id}', 'Admin\ShowtimeController@destroy')
    ->middleware(['auth', 'admin'])
    ->name('admin.showtimes.destroy');

    
Route::get('/admin/bookings', 'Admin\BookingController@index')
    ->middleware(['auth', 'admin'])
    ->name('admin.bookings.index');

    
Route::get('/bookings/create', 'BookingController@create')
    ->middleware('auth')
    ->name('customer.bookings.create');

Route::post('/bookings', 'BookingController@store')
    ->middleware('auth')
    ->name('customer.bookings.store');

   
Route::get('/my-bookings', 'BookingController@history')
    ->middleware('auth')
    ->name('customer.bookings.history');

    
Route::get('/my-bookings/{id}/ticket', 'BookingController@ticket')
    ->middleware('auth')
    ->name('customer.bookings.ticket');

    
Route::patch('/admin/bookings/{id}/status', 'Admin\BookingController@updateStatus')
    ->middleware(['auth', 'admin'])
    ->name('admin.bookings.status');

    
/*
|--------------------------------------------------------------------------
| Chuyển hướng sau khi đăng nhập
|--------------------------------------------------------------------------
*/


Route::get('/home', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect('/');

})->middleware('auth');


/*
|--------------------------------------------------------------------------
| Danh sách phim MovieHub từ MySQL
|--------------------------------------------------------------------------
*/

Route::get('/cinema/movies', function () {

    $nowShowing = \App\Movie::where('status', 'now_showing')
        ->orderBy('id', 'desc')
        ->get();

    $comingSoon = \App\Movie::where('status', 'coming_soon')
        ->orderBy('id', 'desc')
        ->get();

    return view('cinema.movies.index', compact(
        'nowShowing',
        'comingSoon'
    ));

})->name('cinema.movies.index');


/*
|--------------------------------------------------------------------------
| Chi tiết phim MovieHub
|--------------------------------------------------------------------------
*/

Route::get('/cinema/movies/{id}', function ($id) {

    $movie = \App\Movie::findOrFail($id);

    $showtimes = \App\Showtime::where('movie_id', $movie->id)
        ->where('status', 'scheduled')
        ->where('starts_at', '>', now())
        ->orderBy('starts_at', 'asc')
        ->get();

    return view('cinema.movies.show', compact(
        'movie',
        'showtimes'
    ));

})
->where('id', '[0-9]+')
->name('cinema.movies.show');


Route::get('/admin/tickets/{id}/verify', 'Admin\BookingController@verifyTicket')
    ->middleware(['auth', 'admin', 'signed'])
    ->name('admin.tickets.verify');

    
Route::post('/admin/tickets/{id}/use',
    'Admin\BookingController@markTicketUsed')
    ->middleware(['auth', 'admin'])
    ->name('admin.tickets.use');


Route::get(
    '/my-bookings/{id}/payment',
    'BookingController@payment'
)
->middleware('auth')
->name('customer.bookings.payment');


Route::get(
    '/admin/bookings/{id}/verify-payment',
    '\App\Http\Controllers\Admin\BookingController@paymentForm'
)
->middleware(['auth', 'admin'])
->name('admin.bookings.payment.form');

Route::post(
    '/admin/bookings/{id}/confirm-payment',
    '\App\Http\Controllers\Admin\BookingController@confirmPayment'
)
->middleware(['auth', 'admin'])
->name('admin.bookings.payment.confirm');


Route::get(
    '/admin/tickets/lookup',
    'Admin\BookingController@ticketLookup'
)
->middleware(['auth', 'admin'])
->name('admin.tickets.lookup');


/*
|--------------------------------------------------------------------------
| MOVIEHUB - UPLOAD ANH DAI DIEN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Hien thi trang thay doi anh dai dien
    Route::get('/profile/avatar',
        [\App\Http\Controllers\AvatarController::class, 'edit'])
        ->name('profile.avatar.edit');

    // Xu ly upload anh dai dien
    Route::post('/profile/avatar',
        [\App\Http\Controllers\AvatarController::class, 'update'])
        ->name('profile.avatar.update');

});
