<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QrcodeRequest;
use App\Models\Qrcode;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\Rule;
use Str;

/**
 * Class QrcodeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QrcodeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
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
        CRUD::setModel(Qrcode::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/qrcode');
        CRUD::setEntityNameStrings('qrcode', 'qrcodes');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(['name' => 'nama_qrcode', 'type' => 'text', 'label' => 'Nama QR']);
        // $this->crud->addColumn(['name' => 'kode', 'type' => 'text', 'label' => 'Kode']);
        $this->crud->addColumn([
            'name' => 'merchant_id',
            'type' => 'select',
            'label' => 'Merchant',
            'entity' => 'merchant',
            'attribute' => 'title',
        ]);
        $this->crud->addColumn([
            'name' => 'promo_id',
            'type' => 'select',
            'label' => 'Dari Promo',
            'entity' => 'promo',
            'attribute' => 'name',
        ]);
        $this->crud->addColumn(['name' => 'masa_berlaku_mulai', 'type' => 'datetime', 'label' => 'Mulai']);
        $this->crud->addColumn(['name' => 'masa_berlaku_selesai', 'type' => 'datetime', 'label' => 'Selesai']);
        $this->crud->addColumn(['name' => 'aktif', 'type' => 'check', 'label' => 'Aktif']);
        $this->crud->addColumn(['name' => 'jumlah_penggunaan', 'type' => 'number', 'label' => 'Digunakan']);

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
        CRUD::setValidation(QrcodeRequest::class);

        /*
        |--------------------------------------------------------------------------
        | TAB 1 - Informasi QR
        |--------------------------------------------------------------------------
        */

        CRUD::addField([
            'name' => 'nama_qrcode',
            'type' => 'text',
            'label' => 'Nama QR',
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'merchant_id',
            'type' => 'select2',
            'label' => 'Merchant',
            'entity' => 'merchant',
            'attribute' => 'title',
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'promo_id',
            'type' => 'select2',
            'label' => 'Dari Promo',
            'entity' => 'promo',
            'attribute' => 'name',
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'tipe_qr',
            'type' => 'select_from_array',
            'label' => 'Tipe QR Code',
            'options' => [
                Qrcode::TIPE_KODE => 'Kode (Generate Otomatis)',
                Qrcode::TIPE_LINK => 'Link (Redirect URL)',
            ],
            'allows_null' => false,
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'redirect_url',
            'type' => 'url',
            'label' => 'Redirect URL',
            'tab' => 'Informasi'
        ]);

        if ($this->crud->getCurrentOperation() === 'update') {
            CRUD::addField([
                'name' => 'kode',
                'type' => 'text',
                'label' => 'Kode QR (Generated)',
                'attributes' => [
                    'readonly' => 'readonly',
                ],
                'tab' => 'Informasi'
            ]);
        }

        CRUD::addField([
            'name' => 'jenis_kerjasama',
            'type' => 'select_from_array',
            'label' => 'Jenis Kerjasama',
            'options' => [
                Qrcode::KERJASAMA_MERCHANT => '100% Merchant',
                Qrcode::KERJASAMA_TB => '100% TB',
                Qrcode::KERJASAMA_COST_SHARING => 'Cost Sharing',
            ],
            'allows_null' => false,
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'tb_percentage',
            'type' => 'number',
            'label' => 'TB Percentage (%)',
            'attributes' => [
                'step' => '0.01',
                'min' => 0,
                'max' => 100
            ],
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'merchant_percentage',
            'type' => 'number',
            'label' => 'Merchant Percentage (%)',
            'attributes' => [
                'step' => '0.01',
                'min' => 0,
                'max' => 100
            ],
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'tipe_hadiah',
            'type' => 'select_from_array',
            'label' => 'Tipe Hadiah',
            'options' => [
                Qrcode::HADIAH_DIRECT => 'Direct Gift',
                Qrcode::HADIAH_UNDIAN => 'Undian',
            ],
            'allows_null' => false,
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'benefit',
            'type' => 'text',
            'label' => 'Hadiah/Benefit',
            'tab' => 'Informasi'
        ]);

        CRUD::addField([
            'name' => 'nominal',
            'type' => 'number',
            'label' => 'Nominal Hadiah',
            'prefix' => 'Rp',
            'attributes' => [
                'step' => '0.01',
                'min' => 0
            ],
            'tab' => 'Informasi'
        ]);

        /*
        |--------------------------------------------------------------------------
        | TAB 2 - Pengaturan Waktu
        |--------------------------------------------------------------------------
        */

        CRUD::addField([
            'name' => 'masa_berlaku_mulai',
            'type' => 'datetime_picker',
            'label' => 'Tanggal Mulai',
            'tab' => 'Waktu Aktif'
        ]);

        CRUD::addField([
            'name' => 'masa_berlaku_selesai',
            'type' => 'datetime_picker',
            'label' => 'Tanggal Selesai',
            'tab' => 'Waktu Aktif'
        ]);

        CRUD::addField([
            'name' => 'jam_mulai',
            'type' => 'time',
            'label' => 'Jam Mulai (Opsional)',
            'hint' => 'Kosongkan jika aktif 24 jam',
            'tab' => 'Waktu Aktif'
        ]);

        CRUD::addField([
            'name' => 'jam_selesai',
            'type' => 'time',
            'label' => 'Jam Selesai (Opsional)',
            'tab' => 'Waktu Aktif'
        ]);

        CRUD::addField([
            'name' => 'hari_aktif',
            'type' => 'select2_from_array',
            'label' => 'Hari Aktif (Opsional)',
            'options' => [
                'mon' => 'Senin',
                'tue' => 'Selasa',
                'wed' => 'Rabu',
                'thu' => 'Kamis',
                'fri' => 'Jumat',
                'sat' => 'Sabtu',
                'sun' => 'Minggu',
            ],
            'allows_multiple' => true,
            'hint' => 'Kosongkan jika aktif setiap hari',
            'tab' => 'Waktu Aktif'
        ]);

        /*
        |--------------------------------------------------------------------------
        | TAB 3 - Penggunaan
        |--------------------------------------------------------------------------
        */

        CRUD::addField([
            'name' => 'max_penggunaan',
            'type' => 'number',
            'label' => 'Maksimal Penggunaan',
            'hint' => 'Kosongkan jika tidak terbatas',
            'tab' => 'Penggunaan'
        ]);

        CRUD::addField([
            'name' => 'aktif',
            'type' => 'checkbox',
            'label' => 'Status Aktif',
            'tab' => 'Penggunaan'
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
