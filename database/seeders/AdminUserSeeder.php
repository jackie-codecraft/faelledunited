<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Sam Ciaramilaro',
            'email' => 'sam@sc-codecraft.com',
            'password' => Hash::make('changeme'),
        ]);
    }
}
