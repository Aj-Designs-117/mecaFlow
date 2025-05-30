<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Alan Jafet',
            'email' => 'alan@meca.com',
            'email_verified_at' => now(),
            'password' => bcrypt('231244'),
            'remember_token' => Str::random(10),
        ])->assignRole('Administrador');
        // User::factory(80)->create();
    }
    
}
