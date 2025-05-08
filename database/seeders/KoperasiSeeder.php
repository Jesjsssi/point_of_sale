<?php

namespace Database\Seeders;

use App\Models\Koperasi;
use Illuminate\Database\Seeder;

class KoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Koperasi::create([
            'nama_koperasi' => 'Koperasi A',
            'alamat' => 'Jl. A No. 1',
            'telepon' => '08123456789',
            'email' => 'koperasia@example.com',
        ]);

        Koperasi::create([
            'nama_koperasi' => 'Koperasi B',
            'alamat' => 'Jl. B No. 2',
            'telepon' => '08234567890',
            'email' => 'koperasib@example.com',
        ]);
    }
} 