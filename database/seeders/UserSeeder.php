<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = [
        'name' => 'Admin',
        'email' => 'admin@laravel.com',
        'password' => Hash::make('password'),
        'date_of_birth' => '1990-10-09'
       ];
       
       User::create($user);

       User::factory(10)->create();
    }
}
