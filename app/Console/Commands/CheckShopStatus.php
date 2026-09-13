<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckShopStatus extends Command
{

    protected $signature = 'pos:status {jam?}';


    protected $description = 'Mengecek status operasional Toko Kelontong POS';

    /**
     *  Logika utama yang dijalankan oleh perintah.
     */
    public function handle()
    {
        // Meminta input nama kasir
        $namaKasir = $this->ask('Masukkan nama Anda: ');

        // Mengambil nilai argumen jam, default jam 10 jika tidak diisi
        $jam = $this->argument('jam') ?? 10;

        $this->info("=== SISTEM MONITORING TOKO KELONTONG ===");

        // Logika pengecekan jam kerja (Buka antara jam 08.00 - 21.00 WIB)
        if ($jam >= 8 && $jam <= 21) {
            $this->info("Halo {$namaKasir}, Status Toko pada jam {$jam}:00 WIB adalah: BUKA");
            $this->comment("Silakan kasir bersiap di meja transaksi.");
        } else {
            $this->error("Halo {$namaKasir}, Status Toko pada jam {$jam}:00 WIB adalah: TUTUP");
            $this->warn("Akses transaksi kasir dinonaktifkan sementara.");
        }
    }
}