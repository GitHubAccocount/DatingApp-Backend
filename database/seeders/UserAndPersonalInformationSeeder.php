<?php

namespace Database\Seeders;

use App\Models\PersonalInformation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAndPersonalInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(PersonalInformation::factory())
            ->count(2000)
            ->create();
    }
}
