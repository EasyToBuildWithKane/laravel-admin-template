<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ---------- Admin ----------
        User::create([
            'name' => 'Admin',
            'first_name' => 'Khoa',
            'last_name' => 'Nguyen',
            'email' => 'admin@erp.com',
            'password' => Hash::make('password'), 
            'group_role' => 'Admin',
            'is_active' => 'active',
            'phone' => '0123456789',
            'photo' => null,
        ]);

        // ---------- Users ----------
        $users = [
            [
                'first_name' => 'Minh',
                'last_name' => 'Tran',
                'email' => 'minh.tran@mail.com',
                'phone' => '0987654321',
            ],
            [
                'first_name' => 'Lan',
                'last_name' => 'Pham',
                'email' => 'lan.pham@mail.com',
                'phone' => '0981234567',
            ],
            [
                'first_name' => 'Hieu',
                'last_name' => 'Le',
                'email' => 'hieu.le@mail.com',
                'phone' => '0982345678',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'password' => Hash::make('password'), 
                'group_role' => 'User',
                'is_active' => 'active',
                'phone' => $user['phone'],
            ]);
        }
    }
}
