<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // <-- TAMBAHKAN BARIS INI
use PDF; // Alias dari DomPDF

class LaporanController extends Controller
{
    public function generatePDF()
    {
        $data = [
            'title' => 'Laporan Pegawai',
            'tanggal' => date('d-m-Y'),
            'pegawai' => [
                ['nama' => 'Andi', 'jabatan' => 'Manager'],
                ['nama' => 'Budi', 'jabatan' => 'Staff'],
            ]
        ];

        $pdf = PDF::loadView('laporan.pegawai', $data)->setPaper('A4', 'landscape');
        
        // Unduh file PDF
        return $pdf->download('laporan-pegawai.pdf');
    }
}