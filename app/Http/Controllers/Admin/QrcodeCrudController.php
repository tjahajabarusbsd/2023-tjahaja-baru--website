<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QrcodeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Validation\Rule;

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
        CRUD::setModel(\App\Models\Qrcode::class);
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
        // CRUD::setValidation(QrcodeRequest::class);
        $this->crud->setValidation([
            'nama_qrcode' => 'required|min:3',
            'kode' => [
                'nullable',
                Rule::unique('qrcodes', 'kode')
                    ->ignore($this->crud->getCurrentEntryId()), // abaikan ID saat edit
            ],
            'merchant_id' => 'nullable|exists:merchants,id',
            // 'poin' => 'required|integer|min:1',
            'masa_berlaku_mulai' => 'required|date',
            'masa_berlaku_selesai' => 'required|date|after:masa_berlaku_mulai',
            'max_penggunaan' => 'nullable|integer|min:1'
        ]);

        $this->crud->addField(['name' => 'nama_qrcode', 'type' => 'text', 'label' => 'Nama QR']);
        $this->crud->addField(['name' => 'merchant_id', 'type' => 'select2', 'label' => 'Merchant', 'entity' => 'merchant', 'attribute' => 'title']);
        $this->crud->addField(['name' => 'promo_id', 'type' => 'select2', 'label' => 'Dari Promo', 'entity' => 'promo', 'attribute' => 'name']);
        $this->crud->addField(['name' => 'kode', 'type' => 'text', 'label' => 'Kode Unik', 'hint' => 'Akan digenerate otomatis jika kosong']);
        $this->crud->addField(['name' => 'benefit', 'type' => 'text', 'label' => 'Benefit']);
        // $this->crud->addField(['name' => 'poin', 'type' => 'number', 'label' => 'Jumlah Poin']);
        $this->crud->addField(['name' => 'masa_berlaku_mulai', 'type' => 'datetime_picker', 'label' => 'Masa Berlaku Mulai']);
        $this->crud->addField(['name' => 'masa_berlaku_selesai', 'type' => 'datetime_picker', 'label' => 'Masa Berlaku Selesai']);
        $this->crud->addField(['name' => 'aktif', 'type' => 'checkbox', 'label' => 'Status Aktif']);
        $this->crud->addField(['name' => 'max_penggunaan', 'type' => 'number', 'label' => 'Maksimal Penggunaan (kosongkan jika tak terbatas)']);

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

    // Override untuk auto-generate kode
    public function store()
    {
        $request = $this->crud->validateRequest();

        // Auto-generate kode jika kosong
        if (empty($request->kode)) {
            $request->merge(['kode' => 'QR-' . strtoupper(uniqid())]);
        }

        $request->merge(['created_by' => backpack_user()->id]);

        return $this->traitStore();
    }
}
