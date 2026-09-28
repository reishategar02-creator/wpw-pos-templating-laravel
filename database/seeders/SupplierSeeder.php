<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Indofood Sukses Makmur Tbk',
                'phone' => '08123456789',
                'address' => 'Sudirman Plaza, Indofood Tower, Jl. Jend. Sudirman, Jakarta Selatan',
            ],
            [
                'name' => 'PT. Unilever Indonesia Tbk',
                'phone' => '08987654321',
                'address' => 'Grha Unilever, Green Office Park, Jl. BSD Boulevard Barat, Tangerang',
            ],
            [
                'name' => 'PT. Mayora Indah Tbk',
                'phone' => '08135798642',
                'address' => 'Gedung Mayora, Jl. Tomang Raya, Jakarta Barat',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}