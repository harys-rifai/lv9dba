<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory([
            'name' => 'Administrator',
            'email' => 'admin@prudential.co.id',
            'password' => Hash::make('admin'),
        ])
            ->count(1)
            ->withPersonalCompany()
            ->withEmployee(1)
            ->withSuperAdminRole()
            ->create();

        User::factory([
            'name' => 'Haris Rifai',
            'email' => 'harys@prudential.co.id',
            'password' => Hash::make('Dikpora31'),
        ])
            ->count(1)
            ->withPersonalCompany()
            ->withEmployee(2)
            ->withSuperAdminRole()
            ->create();

        User::factory([
             'name' => '401405',
             'email' => 'arif.rahman@prudential.co.id',
             'password' => Hash::make('Password09'),
        ])
            ->count(1)
            ->withPersonalCompany()
            ->withEmployee(3)
            ->withSuperAdminRole()
            ->create();
            User::factory([
                'name' => 'Afdoli Fahmi',
                'email' => 'afdoli.fahmi@prudential.co.id',
                'password' => Hash::make('Password09'),
           ])
               ->count(1)
               ->withPersonalCompany()
               ->withEmployee(4)
               ->withSuperAdminRole()
               ->create();
    }
}

