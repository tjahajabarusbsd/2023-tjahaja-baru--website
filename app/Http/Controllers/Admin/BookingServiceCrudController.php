<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookingServiceCRUDRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BookingServiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookingServiceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\BookingService::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/booking-service');
        CRUD::setEntityNameStrings('booking service', 'booking services');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'user',
            'type' => 'select',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\Models\UserPublic",
            'label' => 'Nama User',
        ]);
        CRUD::column('motor_id');
        CRUD::column('booking_id');
        CRUD::column('dealer_id');
        CRUD::column('tanggal');
        CRUD::column('jam');

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
        CRUD::setValidation(BookingServiceCRUDRequest::class);

        CRUD::addField([
            'name' => 'user_id', // field di tabel booking_services
            'label' => 'User',
            'type' => 'select',
            'entity' => 'user', // nama method relasi di model BookingService
            'attribute' => 'name', // kolom yang akan ditampilkan
            'model' => "App\Models\UserPublic",
            'attributes' => [
                'disabled' => 'disabled', // nonaktifkan inputan
            ],
        ]);

        CRUD::addField([
            'name' => 'motor_id',
            'label' => 'Nomor Rangka',
            'type' => 'select',
            'entity' => 'motor', // nama method relasi di model BookingService
            'attribute' => 'nomor_rangka', // kolom di tabel nomor_rangkas
            'model' => "App\Models\NomorRangka",
            'attributes' => [
                'disabled' => 'disabled', // nonaktifkan inputan
            ],
        ]);
        CRUD::field('booking_id')->type('text')->attributes(['disabled' => 'disabled']);
        CRUD::field('dealer_id')->type('text')->attributes(['disabled' => 'disabled']);
        CRUD::field('tanggal')->type('text')->attributes(['disabled' => 'disabled']);
        CRUD::field('jam')->type('text')->attributes(['disabled' => 'disabled']);
        CRUD::field('status');
        CRUD::field('status')->type('enum')->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed'
        ]);

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