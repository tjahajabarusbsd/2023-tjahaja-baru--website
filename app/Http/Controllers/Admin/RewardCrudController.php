<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RewardRequest;
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
        CRUD::column('title');
        CRUD::column('merchant_id')->type('relationship')->label('Merchant');
        CRUD::column('point');
        CRUD::column('quantity');
        CRUD::column('masa_berlaku_mulai');
        CRUD::column('masa_berlaku_selesai');
        CRUD::column('aktif')->type('boolean');

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

        CRUD::field('merchant_id')->type('relationship')->label('Merchant');
        CRUD::field('title');
        CRUD::field('image')->type('image')->upload(true);
        CRUD::field('point');
        CRUD::field('quantity');
        CRUD::field('masa_berlaku_mulai')->type('date');
        CRUD::field('masa_berlaku_selesai')->type('date');
        CRUD::field('deskripsi')->type('textarea');
        CRUD::field('terms_conditions')->type('textarea');
        CRUD::field('aktif')->type('checkbox');

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
