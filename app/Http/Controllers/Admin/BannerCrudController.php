<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BannerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BannerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BannerCrudController extends CrudController
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
        CRUD::setModel("\App\Models\Banner");
        CRUD::setRoute("admin/banner");
        CRUD::setEntityNameStrings('banner', 'banners');
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
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Tanggal Buat',
            'type' => 'date',
            'format' => 'll'
        ]);

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
        CRUD::setValidation(BannerRequest::class);

        /**
         * Another type of validation without using Request
         */
        // $this->crud->setValidation([
        //     'name' => 'required|min:5',
        // ]);

        // $rules = [
        //     'name' => 'required|min:2',
        //     'image' => 'required'
        // ];
        // $messages = [
        //     'name.required' => 'You gotta give it a name, man.',
        //     'name.min' => 'You came up short. Try more than 2 characters.',
        //     'image.required' => 'Pilih image dulu bro'
        // ];

        // $this->crud->setValidation($rules, $messages);

        CRUD::field('name');
        CRUD::field('image')->type('image')->upload(true);
        CRUD::field('is_active')->label('show')->type('checkbox');
        CRUD::field('link')->label('url')->type('text');
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
}
