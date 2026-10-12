<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeatureStatusRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FeatureStatusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeatureStatusCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\FeatureStatus::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/feature-status');
        CRUD::setEntityNameStrings('status fitur', 'status fitur');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('label')->label('Fitur');
        CRUD::column('key')->label('Key');
        CRUD::column('is_active')->label('Aktif')->type('boolean');
        CRUD::column('maintenance_message')->label('Pesan');
        CRUD::column('maintenance_until')->label('Estimasi selesai')->type('datetime');
        CRUD::column('updated_at')->label('Terakhir diubah')->type('datetime');

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
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(FeatureStatusRequest::class);

        CRUD::field('label')->label('Fitur')
            ->attributes(['readonly' => 'readonly']);

        CRUD::field('key')->label('Key')
            ->attributes(['readonly' => 'readonly'])
            ->hint('Dipakai oleh aplikasi, tidak boleh diubah.');

        CRUD::field('is_active')->label('Fitur aktif')->type('checkbox')
            ->hint('Hilangkan centang untuk menutup fitur di aplikasi dan API.');

        CRUD::field('maintenance_message')->label('Pesan untuk user')->type('text')
            ->hint('Wajib diisi saat fitur dinonaktifkan. Tampil di dialog aplikasi.');

        CRUD::field('maintenance_until')->label('Estimasi selesai')->type('datetime_picker')
            ->hint('Opsional. Hanya informasi, fitur tidak otomatis aktif kembali.');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }
}
