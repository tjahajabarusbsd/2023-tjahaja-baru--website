<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CreditTenor extends Model
{
  use CrudTrait;

  protected $fillable = [
    'months',
    'flat_rate',
    'life_insurance_rate',
    'provision_percent',
    'is_active',
  ];

  protected $casts = [
    'months' => 'integer',
    'flat_rate' => 'float',
    'life_insurance_rate' => 'float',
    'provision_percent' => 'float',
    'is_active' => 'boolean',
  ];
}
