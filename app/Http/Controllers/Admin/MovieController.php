<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Movie;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

public function index(Request $request)
{
    // Lay tu khoa tu o tim kiem
    $search = trim($request->query('search', ''));

    // Tao truy van Eloquent
    $query = Movie::query();

    // Neu co tu khoa thi loc theo ten phim
    if ($search !== '') {
        $query->where('title', 'LIKE', '%' . $search . '%');
    }

    // Sap xep va phan trang
    $movies = $query->orderBy('id', 'asc')
                    ->paginate(5);

    // Giu tu khoa khi chuyen trang
    $movies->appends(['search' => $search]);

    return view('admin.movies.index', compact('movies'));
}

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

public function create()
{
    return view('admin.movies.create');
}


    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'genre' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'nullable|integer|min:1',
        'release_date' => 'nullable|date',
       
        'poster' => 'nullable|url|max:255',
        'poster_file' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        'status' => 'required|in:coming_soon,now_showing',

    ]);

unset($data['poster_file']);

if ($request->hasFile('poster_file')) {

    $folder = public_path('uploads/posters');

    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $file = $request->file('poster_file');

    $filename = $file->hashName();

    $file->move($folder, $filename);

    
$data['poster'] = asset('uploads/posters/' . $filename);

}

    Movie::create($data);

    return redirect()
        ->route('admin.movies.index')
        ->with('success', 'Thêm phim thành công!');
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
    $movie = Movie::findOrFail($id);

    return view('admin.movies.edit', compact('movie'));
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
    $movie = Movie::findOrFail($id);

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'genre' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'nullable|integer|min:1',
        'release_date' => 'nullable|date',
        
        'poster' => 'nullable|url|max:255',
        'poster_file' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        'status' => 'required|in:coming_soon,now_showing',

    ]);

unset($data['poster_file']);

if ($request->hasFile('poster_file')) {

    $folder = public_path('uploads/posters');

    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $file = $request->file('poster_file');

    $filename = $file->hashName();

    $file->move($folder, $filename);

    
$data['poster'] = asset('uploads/posters/' . $filename);

}

    $movie->update($data);

    return redirect()
        ->route('admin.movies.index')
        ->with('success', 'Cập nhật phim thành công!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
public function destroy($id)
{
    $movie = Movie::findOrFail($id);

    // Không xóa phim đã có suất chiếu
    if ($movie->showtimes()->exists()) {
        return redirect()
            ->route('admin.movies.index')
            ->with('error', 'Không thể xóa phim đã có suất chiếu!');
    }

    $movie->delete();

    return redirect()
        ->route('admin.movies.index')
        ->with('success', 'Xóa phim thành công!');
}

}
