<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // User::create([
        //     // 'username' => 'bagas',
        //     'name' => 'Bagas Roberto',
        //     'email' => 'roberto.bagas7@gmail.com',
        //     'password' => bcrypt('111111')
        // ]);

        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit_articles']);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);




        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
