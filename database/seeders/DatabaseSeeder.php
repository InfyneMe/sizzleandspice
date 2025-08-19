<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            [
                'uuid' => 'SS-AD-0001',
                'name' => 'Arpita Roy',
                'email' => 'roya91455@gmail.com',
                'phone' => '8794748689',
                'password' => Hash::make('Pizza&Mountain$Clock7Lightning'),
                'email_verified_at' => now(),
            ],
            [
                'uuid' => 'SS-AD-0002',
                'name' => 'Pinak Suklabaidya',
                'email' => 'pinaksuklabaidya517@gmail.com',
                'phone' => '6901979091',
                'password' => Hash::make('Bill&PlantKitchenEngine1'),
                'email_verified_at' => now(),
            ],
            [
                'uuid' => 'SS-AD-0003',
                'name' => 'Bishal Deb',
                'email' => 'solution@infyne.in',
                'phone' => '8099227246',
                'password' => Hash::make('Yuc8$RikA34%ZoPPao98t'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
