<?php

namespace Database\Seeders;

use App\Models\User;
use App\Helpers\Helper;
use App\Helpers\Enums\RoleType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::create([
      'name' => 'Brendan Roger',
      'email' => 'roger@gmail.com',
      'email_verified_at' => now(),
      'password' => bcrypt(Helper::DEFAULT_PASSWORD),
      'status' => true,
    ])->assignRole(RoleType::STAFF->value);
  }
}
