<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Development',
            'email'             => 'development@damirich.id',
            "email_verified_at" => Carbon::now(),
            'password'          => Hash::make('password')
        ]);
        User::create([
            'name'              => 'Member One',
            'email'             => 'member1@damirich.id',
            "email_verified_at" => Carbon::now(),
            'password'          => Hash::make('password')
        ]);
        User::create([
            'name'              => 'Member Two',
            'email'             => 'member2@damirich.id',
            "email_verified_at" => Carbon::now(),
            'password'          => Hash::make('password')
        ]);
    }
}
