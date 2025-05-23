<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama_user'     => 'Andre Septio Irhamni Wicaksana',
                'email_user'    => 'andre@gmail.com',
                'password_user' => Hash::make('P@ssw0rd'), // hash password
                'created_at'    => Carbon::now()
            ],
            [
                'nama_user'     => 'Oppo',
                'email_user'    => 'oppo@gmail.com',
                'password_user' => Hash::make('P@ssw0rd'), // hash password
                'created_at'    => Carbon::now()
            ],
        ]);
    }
}
