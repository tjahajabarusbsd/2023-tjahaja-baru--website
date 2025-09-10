<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RewardRequest;
use App\Models\Reward;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RewardCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RewardCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Reward::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/reward');
        CRUD::setEntityNameStrings('reward', 'rewards');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('title')->label('Nama Reward');
        CRUD::column('merchant_id')->type('relationship')->label('Merchant');
        CRUD::column('point')->label('Poin');
        CRUD::column('quantity')->label('Kuantitas');
        CRUD::column('masa_berlaku_mulai');
        CRUD::column('masa_berlaku_selesai');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RewardRequest::class);

        CRUD::field('merchant_id')->type('relationship')->label('Pilih Merchant');
        CRUD::field('type')
            ->type('select_from_array')
            ->options(Reward::TYPES)
            ->label('Jenis Reward')
            ->allows_null(false)
            ->default('voucher');
        CRUD::field('title')->type('text')->label('Nama Reward');
        CRUD::field('image')->type('image')->upload(true);
        CRUD::field('point')->type('number')->label('Poin Reward');
        CRUD::field('quantity')->type('number')->label('Kuantitas Reward');
        CRUD::field('discount_type')
            ->type('select_from_array')
            ->options(Reward::DISCOUNT_TYPES)
            ->label('Jenis Diskon')
            ->allows_null(false)
            ->default('percentage');
        CRUD::field('discount_value')->type('number')->label('Nilai Diskon');
        CRUD::field('masa_berlaku_mulai')->type('date');
        CRUD::field('masa_berlaku_selesai')->type('date');
        CRUD::field('deskripsi')->type('textarea');
        CRUD::field('terms_conditions')->type('textarea')->label('Syarat & Ketentuan');
        CRUD::field('aktif')->type('checkbox')->label('Aktif?')->default(true);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
