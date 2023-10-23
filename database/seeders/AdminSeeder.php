<?php

namespace Database\Seeders;

use App\Models\User;
use App\Helpers\Helper;
use App\Helpers\Enums\RoleType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::create([
      'name' => 'Administrator',
      'email' => 'admin@gmail.com',
      'email_verified_at' => now(),
      'password' => bcrypt(Helper::DEFAULT_PASSWORD), // password
      'status' => true,
    ])->assignRole(RoleType::ADMIN->value);
  }
}
