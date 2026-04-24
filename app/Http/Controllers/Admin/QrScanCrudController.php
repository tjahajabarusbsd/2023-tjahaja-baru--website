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

        $this->crud->denyAccess(['create', 'delete', 'show']);
        $this->crud->addClause('with', ['user', 'qrcode.promo.merchant']);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'scanned_at_range',
            'label' => 'Tanggal Scan'
        ], false, function ($value) {
            $dates = json_decode($value);

            if (!empty($dates->from)) {
                $this->crud->addClause('where', 'scanned_at', '>=', $dates->from);
            }

            if (!empty($dates->to)) {
                $this->crud->addClause('where', 'scanned_at', '<=', $dates->to . ' 23:59:59');
            }
        });

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

        $this->crud->addColumn([
            'name' => 'merchant',
            'label' => 'Merchant',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->qrcode?->promo?->merchant?->title ?? '-';
            },
            'orderable' => false,
            'searchLogic' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'promo_name',
            'label' => 'Promo',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->qrcode?->promo?->name ?? 'N/A';
            },
            'orderable' => false,
            'searchLogic' => false,
        ]);

        $this->crud->addColumn([
            'name' => 'qrcode_name',
            'label' => 'Nama QR Code',
            'type' => 'closure',
            'function' => function ($entry) {
                return $entry->qrcode?->nama_qrcode ?? 'N/A';
            },
            'orderable' => false,
            'searchLogic' => false,
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
        $entry = $this->crud->getCurrentEntry();
        $scanCode = e($entry->scan_code ?? '-');
        $userName = e(optional($entry->user)->name ?? '-');
        $merchantName = e($entry->qrcode?->promo?->merchant?->title ?? '-');
        $promoName = e($entry->qrcode?->promo?->name ?? '-');
        $qrCodeName = e($entry->qrcode?->nama_qrcode ?? '-');
        $scannedAt = e(optional($entry->scanned_at)->format('d-m-Y H:i:s') ?? '-');

        CRUD::addField([
            'name' => 'scan_code_info',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>ID Scan: </strong>' . $scanCode . '</p>',
        ]);

        CRUD::addField([
            'name' => 'user_public_id_info',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nama: </strong>' . $userName . '</p>',
        ]);

        CRUD::addField([
            'name' => 'merchant_info',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Merchant: </strong>' . $merchantName . '</p>',
        ]);

        CRUD::addField([
            'name' => 'promo_info',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Promo: </strong>' . $promoName . '</p>',
        ]);

        CRUD::addField([
            'name' => 'qrcode_info',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nama QR Code: </strong>' . $qrCodeName . '</p>',
        ]);

        CRUD::addField([
            'name' => 'scanned_at_info',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Tanggal Scan: </strong>' . $scannedAt . '</p>',
        ]);

        CRUD::field('image')->type('image')->label('Upload Bukti Scan')->upload(true);
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
    }
}
