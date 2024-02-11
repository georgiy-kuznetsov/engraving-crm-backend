<?php

namespace Database\Seeders\Initial;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'login' => 'owner',
            'email' => 'owner@example.com',
            'email_verified_at' => null,
            'password' => Hash::make('owner12345'),

            'first_name' => null,
            'last_name' => null,
            'avatar_large' => null,
            'avatar_small' => null,

            'role' => 'owner',
            'active' => true,

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
