<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name' => 'Admin', 'username' => 'admin', 'password' => Hash::make('admin'), 'role_id' => '1','kode_desa' => null],
            ['name' => 'Verifikator 1', 'username' => 'verifikator1', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Verifikator 2', 'username' => 'verifikator2', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Verifikator 3', 'username' => 'verifikator3', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Verifikator 4', 'username' => 'verifikator4', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Verifikator 5', 'username' => 'verifikator5', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Verifikator 6', 'username' => 'verifikator6', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Betet', 'username' => 'betet', 'password' => Hash::make('12345678'), 'role_id' => '3', 'kode_desa' => '35.22.20.2002'],
        ]);
    }
}
