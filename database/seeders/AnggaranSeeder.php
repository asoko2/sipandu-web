<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desa = Desa::all();

        foreach($desa as $d){
            DB::table('anggarans')->insert([
                'kode_desa' => $d->kode_desa,
                'total_anggaran' => 0,
                'tahun_anggaran' => 2023,
            ]);
        }
    }
}
