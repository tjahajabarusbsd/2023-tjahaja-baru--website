<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EventRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Event;

/**
 * Class EventCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventCrudController extends CrudController
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
        CRUD::setModel(Event::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/event');
        CRUD::setEntityNameStrings('event', 'events');
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
        CRUD::column('type');
        CRUD::column('is_active');
        CRUD::column('start_date');
        CRUD::column('end_date');
        CRUD::column('created_at');

        // Filter by event type
        CRUD::addFilter([
            'name' => 'type',
            'type' => 'dropdown',
            'label' => 'Jenis Event'
        ], Event::TYPES, function ($value) {
            CRUD::addClause('where', 'type', $value);
        });

        // Filter by active status
        CRUD::addFilter([
            'name' => 'is_active',
            'type' => 'dropdown',
            'label' => 'Status Aktif'
        ], [
            1 => 'Aktif',
            0 => 'Tidak Aktif'
        ], function ($value) {
            CRUD::addClause('where', 'is_active', $value);
        });

        // Filter by date range
        CRUD::addFilter([
            'type' => 'date_range',
            'name' => 'date_range',
            'label' => 'Tanggal Event'
        ], false, function ($value) {
            $dates = json_decode($value);
            if ($dates->from) {
                CRUD::addClause('where', 'start_date', '>=', $dates->from);
            }
            if ($dates->to) {
                CRUD::addClause('where', 'end_date', '<=', $dates->to);
            }
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
        CRUD::setValidation(EventRequest::class);

        CRUD::field('name')->label('Nama Event');
        CRUD::field('description')->label('Deskripsi Event')->type('textarea');
        CRUD::field('image')->label('Gambar Event')->type('image')->upload(true);
        CRUD::field('start_date');
        CRUD::field('end_date');
        CRUD::field('type')
            ->type('select_from_array')
            ->options(Event::TYPES)
            ->label('Jenis Event')
            ->allows_null(false)
            ->default('online');
        CRUD::field('is_active')->label('Tampilkan?')->type('checkbox');

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