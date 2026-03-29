<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@sekolah.test'],
            ['name' => 'Admin Bendahara', 'password' => Hash::make('Password')]
        );
        User::updateOrCreate(
            ['email' => 'kepala@sekolah.test'],
            ['name' => 'Kepala Sekolah', 'password' => Hash::make('Password')]
        );
    }
}
