<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Super Admin',
                'email' => 'super.admin@example.com',
                'password' => 'admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'admin',
            ]
        ];
        foreach ($data as $item) {
            User::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => $item['password'],
            ]);
        }
    }
}
