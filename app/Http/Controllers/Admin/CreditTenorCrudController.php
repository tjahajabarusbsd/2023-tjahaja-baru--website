<?php

namespace App\Http\Controllers\Admin;

use App\Models\CreditTenor;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CreditTenorCrudController extends CrudController
{
  use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

  public function setup()
  {
    CRUD::setModel(CreditTenor::class);
    CRUD::setRoute(config('backpack.base.route_prefix') . '/credit-tenor');
    CRUD::setEntityNameStrings('tenor kredit', 'tenor kredit');
  }

  protected function setupListOperation()
  {
    CRUD::column('months')->label('Tenor (bulan)');
    CRUD::column('flat_rate')->label('Bunga Flat / Tahun (%)');
    CRUD::column('life_insurance_rate')->label('Asuransi Jiwa (%)');
    CRUD::column('provision_percent')->label('Provisi (%)');
    CRUD::column('is_active')->label('Aktif')->type('boolean');
  }

  protected function setupCreateOperation()
  {
    CRUD::setValidation([
      'months' => 'required|integer|min:1|unique:credit_tenors,months,' . request()->route('id'),
      'flat_rate' => 'required|numeric|min:0',
      'life_insurance_rate' => 'required|numeric|min:0|lt:100',
      'provision_percent' => 'required|numeric|min:0',
      'is_active' => 'boolean',
    ]);

    CRUD::field('months')->label('Tenor (bulan)')->type('number');
    CRUD::field('flat_rate')->label('Bunga Flat per Tahun (%)')->type('number')->attributes(['step' => '0.01']);
    CRUD::field('life_insurance_rate')->label('Asuransi Jiwa (% dari plafon)')->type('number')->attributes(['step' => '0.0001']);
    CRUD::field('provision_percent')->label('Provisi (% dari OTR - DP)')->type('number')->attributes(['step' => '0.01'])->default(0);
    CRUD::field('is_active')->label('Aktif')->type('checkbox')->default(true);
  }

  protected function setupUpdateOperation()
  {
    $this->setupCreateOperation();
  }
}
