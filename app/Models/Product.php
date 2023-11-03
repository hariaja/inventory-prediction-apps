<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
  use HasFactory, Uuid;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'uuid',
    'code',
    'name',
    'quantity',
    'quantity_one_day',
    'produced_at',
    'expired_at',
    'price',
    'description',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'produced_at' => 'date:c',
    'expired_at' => 'date:c',
  ];

  /**
   * Get the route key for the model.
   */
  public function getRouteKeyName(): string
  {
    return 'uuid';
  }

  /**
   * Relation to Material tables.
   *
   * @return BelongsToMany
   */
  public function materials(): BelongsToMany
  {
    return $this->belongsToMany(Material::class)->withPivot('quantity_used')->withTimestamps();
  }
}
