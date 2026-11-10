<?php

namespace App\Services;

use App\Models\Transaction;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class ReceiptPrinter
{
    private const WIDTH = 32; // printer 58mm = 32 karakter

    private function connector(Transaction $t)
    {
        $name = config('printer.name');

        switch (config('printer.mode')) {
            case 'windows':
                return new WindowsPrintConnector($name);
            case 'cups':
                return new CupsPrintConnector($name);
            default: // simulasi: tulis ke file
                $dir = storage_path('app/receipts');
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                return new FilePrintConnector($dir . '/' . $t->transaction_number . '.txt');
        }
    }

    private function rp($n): string
    {
        return number_format($n, 0, ',', '.');
    }

    private function row(string $left, string $right): string
    {
        $space = max(1, self::WIDTH - strlen($left) - strlen($right));
        return $left . str_repeat(' ', $space) . $right . "\n";
    }

    public function print(Transaction $t): void
    {
        $t->loadMissing('details', 'user');

        $printer = new Printer($this->connector($t));

        try {
            $line  = str_repeat('=', self::WIDTH) . "\n";
            $line2 = str_repeat('-', self::WIDTH) . "\n";

            // Header
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("TOKO RETAIL MAKMUR\n");
            $printer->setEmphasis(false);
            $printer->text("Jl. Contoh No. 123, Jember\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($line);

            // Info transaksi (tanggal & waktu)
            $printer->text('No   : ' . $t->transaction_number . "\n");
            $printer->text('Waktu: ' . $t->created_at->format('d-m-Y H:i:s') . "\n");
            $printer->text('Kasir: ' . ($t->user->name ?? '-') . "\n");
            $printer->text($line2);

            // Daftar item, qty, harga
            foreach ($t->details as $d) {
                $printer->text($d->product_name . "\n");
                $printer->text($this->row(
                    '  ' . $d->qty . ' x ' . $this->rp($d->price),
                    $this->rp($d->subtotal)
                ));
            }
            $printer->text($line2);

            // Subtotal, diskon, total
            $printer->text($this->row('Subtotal', $this->rp($t->subtotal)));
            $printer->text($this->row('Diskon', '-' . $this->rp($t->discount)));
            $printer->text($this->row('Pajak', $this->rp($t->tax)));
            $printer->text($this->row('Biaya Lain', $this->rp($t->other_fee)));
            $printer->text($line);

            $printer->setEmphasis(true);
            $printer->text($this->row('TOTAL', 'Rp' . $this->rp($t->grand_total)));
            $printer->setEmphasis(false);
            $printer->text($this->row('Bayar (' . strtoupper($t->payment_method) . ')', $this->rp($t->paid_amount)));
            $printer->text($this->row('Kembali', $this->rp($t->change_amount)));
            $printer->text($line);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima kasih!\n");
            $printer->feed(3);
            $printer->cut();
        } finally {
            $printer->close();
        }
    }
}