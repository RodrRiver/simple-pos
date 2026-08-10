<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@simplepos.test',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Cajero',
            'email' => 'cajero@simplepos.test',
            'password' => 'password',
            'role' => 'cashier',
        ]);
    }
}
