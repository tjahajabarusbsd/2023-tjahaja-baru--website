<?php

namespace App\Http\Controllers\Admin;

use App\Events\PromoCreated;
use App\Http\Requests\PromoRequest;
use App\Models\Notification;
use App\Models\Promo;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class PromoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PromoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Promo::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/promo');
        CRUD::setEntityNameStrings('promo', 'promo');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('show_on_pc')->type('boolean')->label('Muncul di web?');
        CRUD::column('show_on_mobile')->type('boolean')->label('Muncul di app?');
        CRUD::column('is_active')->type('boolean')->label('Aktif?');
        CRUD::column('start_date')->type('date')->label('Tanggal Mulai');
        CRUD::column('end_date')->type('date')->label('Tanggal Berakhir');

        // filter by active status
        CRUD::addFilter([
            'name' => 'is_active',
            'type' => 'dropdown',
            'label' => 'Status Aktif'
        ], [
            1 => 'Aktif',
            0 => 'Tidak Aktif'
        ], function ($value) {
            $this->crud->addClause('where', 'is_active', $value);
        });

        // filter by show_on_pc
        CRUD::addFilter([
            'name' => 'show_on_pc',
            'type' => 'dropdown',
            'label' => 'Muncul di web?'
        ], [
            1 => 'Ya',
            0 => 'Tidak'
        ], function ($value) {
            $this->crud->addClause('where', 'show_on_pc', $value);
        });

        // filter by show_on_mobile
        CRUD::addFilter([
            'name' => 'show_on_mobile',
            'type' => 'dropdown',
            'label' => 'Muncul di app?'
        ], [
            1 => 'Ya',
            0 => 'Tidak'
        ], function ($value) {
            $this->crud->addClause('where', 'show_on_mobile', $value);
        });

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
        CRUD::setValidation(PromoRequest::class);

        CRUD::field('name');
        CRUD::field('image')->type('image')->upload(true);
        CRUD::field('description')->label('Deskripsi')->type('textarea');
        CRUD::field('terms_conditions')->label('Syarat dan Ketentuan')->type('ckeditor');
        CRUD::field('show_on_pc')->label('Muncul di web?')->type('checkbox');
        CRUD::field('show_on_mobile')->label('Muncul di app?')->type('checkbox');
        CRUD::field('is_active')->label('Apakah aktif?')->type('checkbox');
        CRUD::field('start_date')->type('datetime');
        CRUD::field('end_date')->type('datetime');
        CRUD::field('created_at');
        CRUD::field('updated_at');

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

    public function store()
    {
        $response = $this->traitStore();

        $entry = $this->crud->entry;

        event(new PromoCreated($entry));

        return $response;
    }
}