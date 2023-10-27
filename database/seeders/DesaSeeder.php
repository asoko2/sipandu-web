<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('desas')->insert([
            ['kode_desa' => '35.22.20.2001', 'nama_desa' => 'Batokan', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2002', 'nama_desa' => 'Betet', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2003', 'nama_desa' => 'Tembeling', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2004', 'nama_desa' => 'Sidomukti', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2005', 'nama_desa' => 'Basah', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2006', 'nama_desa' => 'Sambeng', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2007', 'nama_desa' => 'Ngaglik', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2008', 'nama_desa' => 'Kasiman', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2009', 'nama_desa' => 'Sekaran', 'kode_kecamatan' => '35.22.20'],
            ['kode_desa' => '35.22.20.2010', 'nama_desa' => 'Tambakmerak', 'kode_kecamatan' => '35.22.20'],
        ]);
    }
}
