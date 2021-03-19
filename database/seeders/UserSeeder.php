<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
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
        $now = Carbon::now();
        $password = Hash::make('password');

        $seeds = [
            [
                [
                    'email'             => 'fauzil@gmail.com',
                ],
                [
                    'name'              => 'fauzil',
                    'email_verified_at' => $now,
                    'password'          => $password
                ]
            ],
            [
                [
                    'email'             => 'rais@gmail.com',
                ],
                [
                    'name'              => 'rais',
                    'email_verified_at' => $now,
                    'password'          => $password
                ]
            ],
            [
                [
                    'email'             => 'yamin@gmail.com',
                ],
                [
                    'name'              => 'yamin',
                    'email_verified_at' => $now,
                    'password'          => $password
                ]
            ],
            [
                [
                    'email'             => 'aldo@gmail.com',
                ],
                [
                    'name'              => 'aldo',
                    'email_verified_at' => $now,
                    'password'          => $password
                ]
            ],
         ];

         foreach($seeds as $seed) {
             User::updateOrCreate($seed[0],$seed[1]);
         }
    }
}
