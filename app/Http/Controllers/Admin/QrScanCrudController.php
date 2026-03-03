<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\QrScanLog;

/**
 * Class QrScanCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QrScanCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup(): void
    {
        CRUD::setModel(QrScanLog::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/qr-scan-log');
        CRUD::setEntityNameStrings('QR Scan Log', 'QR Scan Logs');
        $this->crud->addClause('with', ['user', 'qrcode.promo']);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        $this->crud->addColumn([
            'name' => 'scan_code',
            'label' => 'ID Scan',
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'user_public_id',
            'type' => 'relationship',
            'label' => 'Nama Konsumen',
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
                return $entry->qrcode?->promo?->name ?? 'N/A';
            }
        ]);

        $this->crud->addColumn([
            'label' => 'Nama QR Code',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->qrcode?->nama_qrcode ?? 'N/A';
            }
        ]);

        $this->crud->addColumn([
            'name' => 'scanned_at',
            'type' => 'datetime',
            'label' => 'Tanggal Scan'
        ]);


        $this->crud->addColumn([
            'name' => 'image',
            'type' => 'image',
            'label' => 'Bukti Scan',
            'height' => '100px',
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
    protected function setupCreateOperation(): void
    {
        // CRUD::setValidation(ActivityScanRequest::class);
        $entry = $this->crud->getCurrentEntry();
        $scanCode = e($entry->scan_code ?? '-');
        $userName = e(optional($entry->user)->name ?? '-');
        $scannedAt = e(optional($entry->scanned_at)->format('d-m-Y H:i:s') ?? '-');

        CRUD::addField([
            'name' => 'scan_code',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>ID Scan: </strong>' . $scanCode . '</p>',
        ]);

        CRUD::addField([
            'name' => 'user_public_id',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nama: </strong>' . $userName . '</p>',
        ]);

        CRUD::addField([
            'name' => 'scanned_at',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Tanggal Scan: </strong>' . $scannedAt . '</p>',
        ]);

        CRUD::field('image')->type('image')->label('Upload Bukti Scan')->upload(true);

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
    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();

        // kalau mode upload saja
        if (request()->boolean('upload')) {

            foreach ($this->crud->fields() as $field) {
                $this->crud->modifyField($field['name'], [
                    'attributes' => ['disabled' => true]
                ]);
            }

            // aktifkan kembali field image
            $this->crud->modifyField('image', [
                'attributes' => []
            ]);
        }
    }
}
