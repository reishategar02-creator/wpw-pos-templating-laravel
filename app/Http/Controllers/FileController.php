<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:jpg,png,pdf|max:2048',
    ]);

    $file = $request->file('file');
    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs('documents', $filename, 'public');

    // Simpan pesan sukses ke session
    session()->flash('success', 'Upload Berhasil! File telah disimpan ke documents.');

    // Redirect kembali ke dashboard kasir
    return redirect()->route('kasir.dashboard');
}
}