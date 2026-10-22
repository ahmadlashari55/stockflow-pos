<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin',   'email' => 'admin@stockflow.test',   'role' => 'admin'],
            ['name' => 'Staff',   'email' => 'staff@stockflow.test',   'role' => 'staff'],
            ['name' => 'Cashier', 'email' => 'cashier@stockflow.test', 'role' => 'cashier'],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active'         => true,
                ]
            );
            $user->syncRoles([$data['role']]);
        }
    }
}