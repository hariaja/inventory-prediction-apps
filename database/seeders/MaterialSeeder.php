<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        'name' => 'Garam',
        'total' => 5000,
        'mass' => 'Gram',
      ],
      [
        'name' => 'Mentega',
        'total' => 15000,
        'mass' => 'Gram',
      ],
      [
        'name' => 'Pewarna Makanan Warna Merah',
        'total' => 5000,
        'mass' => 'Mililiter',
      ],
      [
        'name' => 'Keju',
        'total' => 5000,
        'mass' => 'Gram',
      ],
      [
        'name' => 'Msg',
        'total' => 5000,
        'mass' => 'Gram',
      ],
      [
        'name' => 'Telur',
        'total' => 5000,
        'mass' => 'Mililiter',
      ],
      [
        'name' => 'Tepung Terigu',
        'total' => 30,
        'mass' => 'Kilogram',
      ],
      [
        'name' => 'Tepung Aci',
        'total' => 30,
        'mass' => 'Kilogram',
      ],
    ];

    try {
      DB::transaction(function () use ($items, $random) {
        foreach ($items as $item) {
          $code = Helper::generateUniqueCode('materials', 'code', "MT{$random}", 9, 3);
          $item['code'] = $code;
          Material::create($item);
        }
      });
    } catch (\Exception $e) {
      // Handle errors or duplicate entries here
    }
  }
}
