<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\QrScanLog;
use App\Models\QrCode;

/**
 * Class ActivityScanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QrScanCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(QrScanLog::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/qr-scan-log');
        CRUD::setEntityNameStrings('QR Scan Log', 'QR Scan Logs');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'user_public_id',
            'type' => 'relationship',
            'label' => 'Username',
            'entity' => 'user',
            'attribute' => 'name'
        ]);

        // Merchant dari QR Code
        $this->crud->addColumn([
            'name' => 'merchant_title',
            'label' => 'Merchant',
            'type' => 'text'
        ]);

        // promo
        $this->crud->addColumn([
            'label' => 'Promo',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->qrcode ? $entry->qrcode->promo->name ?? 'N/A' : 'N/A';
            }
        ]);

        $this->crud->addColumn([
            'label' => 'Nama QR Code',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->qrcode ? $entry->qrcode->nama_qrcode ?? 'N/A' : 'N/A';
            }
        ]);

        $this->crud->addColumn([
            'name' => 'scanned_at',
            'type' => 'datetime',
            'label' => 'Tanggal Scan'
        ]);

        CRUD::enableExportButtons();

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
        // CRUD::setValidation(ActivityScanRequest::class);

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
