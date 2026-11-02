<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    // Hien thi trang doi anh dai dien
    public function edit()
    {
        return view('profile.avatar');
    }

    // Xu ly upload anh dai dien
    public function update(Request $request)
    {
        // Kiem tra file anh
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // Lay tai khoan dang dang nhap

/** @var \App\User $user */
$user = Auth::user();


        // Lay file anh nguoi dung tai len
        $file = $request->file('avatar');

        // Thu muc luu anh
        $folder = public_path('uploads/avatars');

        // Tao thu muc neu chua ton tai
        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        // Tao ten anh ngau nhien
        $filename = Str::random(32) . '.' . $file->extension();

        // Luu file anh vao thu muc
        $file->move($folder, $filename);

        // Luu duong dan anh vao MySQL
        $user->avatar = 'uploads/avatars/' . $filename;
        $user->save();

        // Quay ve trang avatar
        return redirect()
            ->route('profile.avatar.edit')
            ->with(
                'success',
                'Cap nhat anh dai dien thanh cong!'
            );
    }
}
