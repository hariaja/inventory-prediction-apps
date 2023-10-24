<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaterialSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $random = date('Ym');
    $items = [
      [
        'code' => Helper::generateCode('materials', 'code', "MT{$random}", 9, 3),
        'name' => 'Tepung',
        'total' => 10,
        'mass' => 'Kilogram',
      ],
    ];

    foreach ($items as $item) {
      Material::create($item);
    }
  }
}
