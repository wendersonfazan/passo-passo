<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()
            ->where('email', 'admin@gmail.com')
            ->exists();

        if ($user) {
            return;
        }
        User::query()->create([
            'name' => "Administrador",
            'email' => "admin@gmail.com",
            'password' => Hash::make('admin123')
        ]);

    }
}
