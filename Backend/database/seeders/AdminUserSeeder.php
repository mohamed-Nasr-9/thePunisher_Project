<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'mohamedabualkhair32@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('020105@Ebo_Mm'),
                'role'     => 'admin',
            ]
        );
    }
}
