<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // Import Facade Intervention Image

class ImageController extends Controller
{
    // Contoh 1: Menampilkan hasil manipulasi (resize) langsung di browser tanpa disimpan
    public function testResize()
    {
        // Pastikan Anda sudah menyiapkan sebuah foto (misal: sample.jpg) di dalam folder public
        $path = public_path('sample.jpg');
        
        // Membuka gambar, mengubah ukuran menjadi 300x300 piksel, lalu meresponnya sebagai JPG
        return Image::make($path)->resize(300, 300)->response('jpg');
    }

    // Contoh 2: Upload gambar melalui form, manipulasi (resize), lalu simpan ke folder public/uploads
    public function uploadAndResize(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        // Proses resize dan simpan ke folder public/uploads
        $image = Image::make($file)->resize(300, 300);
        
        // Cek/buat folder uploads di public jika belum ada, lalu simpan dengan kualitas 75%
        $image->save(public_path('uploads/' . $filename), 75);

        return back()->with('success', 'Gambar berhasil di-upload dan di-resize!');
    }
}