<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Simax1721 - Super Admin',
            'email' => 'simax1721@gmail.com',
            'password' => Hash::make('11111111'),
        ]);
        
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@kwarcabacehbesar.com',
            'password' => Hash::make('11111111'),
        ]);
    }
}
