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
            ['name' => 'Novi', 'username' => 'novi', 'password' => Hash::make('12345678'), 'role_id' => '2', 'kode_desa' => null],
            ['name' => 'Betet', 'username' => 'betet', 'password' => Hash::make('12345678'), 'role_id' => '3', 'kode_desa' => '35.22.20.2002'],
        ]);
    }
}
