<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin Gudang',
            'email' => 'admin-gudang@nikisae.com',
            'password' => bcrypt('111111')
        ]);

        $admin->assignRole('admin-gudang');

        $kepala = User::create([
            'name' => 'Kepala Gudang',
            'email' => 'kepala-gudang@nikisae.com',
            'password' => bcrypt('111111')
        ]);

        $kepala->assignRole('kepala-gudang');

        $penganggung = User::create([
            'name' => 'Penanggung Jawab Gudang',
            'email' => 'pj-gudang@nikisae.com',
            'password' => bcrypt('111111')
        ]);

        $penganggung->assignRole('penanggungjawab');
    }
}
