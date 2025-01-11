<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"              => "Sairus Khalil",
            "uuid"              => "9204923",
            "user_name"         => "admin",
            "email"             => "admin@example.com",
            "role"              => "admin",
            "status"            => "active",
            "is_verified"       => "1",
            "email_verified_at" => now(),
            'password'          => bcrypt('123456'),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
