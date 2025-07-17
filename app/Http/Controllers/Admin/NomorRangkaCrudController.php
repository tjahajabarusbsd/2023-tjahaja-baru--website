<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NomorRangkaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

/**
 * Class NomorRangkaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NomorRangkaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\NomorRangka::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/nomor-rangka');
        CRUD::setEntityNameStrings('nomor rangka', 'nomor rangka');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('nomor_rangka');
        CRUD::column('phone_number')->label('Nomor Handphone');
        CRUD::column('status_verifikasi')->type('enum')->options([
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected'
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
        CRUD::setValidation(NomorRangkaRequest::class);

        CRUD::field('nomor_rangka')->type('text')->attributes(['disabled' => 'disabled'])->label('Nomor Rangka');
        CRUD::field('phone_number')->type('text')->attributes(['disabled' => 'disabled'])->label('Nomor Handphone');        
        CRUD::field('ktp')->type('image')->upload(true)->disk('uploads')->prefix('ktp/');
        CRUD::field('kk')->type('image')->upload(true)->disk('uploads')->prefix('kk/');
        CRUD::field('status_verifikasi')->type('enum')->options([
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected'
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
    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        $request = $this->crud->validateRequest();
        $entry = $this->crud->getEntry($this->crud->getCurrentEntryId());

        $oldStatus = $entry->status_verifikasi;
        $newStatus = $request->input('status_verifikasi');

        // Jika status berubah dari pending → verified
        if ($oldStatus === 'pending' && $newStatus === 'verified') {
            // dapatkan nomor rangka 
            $nomorRangka = $entry->nomor_rangka;
            $url_services = env('GET_URL_SERIVCES');
            $apiUrl = $url_services . "?id=" . $nomorRangka;
            $response = Http::withoutVerifying()->get($apiUrl);
            $data = $response->json();

            // Jika data tidak ditemukan, kembalikan error
            if (!$data) {
                \Alert::error('Nomor Rangka tidak ditemukan.')->flash();
                return redirect()->back();
            }

            if ($data && isset($data[0]['plat'])) {
                $entry->nomor_plat = $data[0]['plat'];
                $entry->save();
            } else {
                $entry->nomor_plat = null;
                $entry->save();
            }

            if ($data && isset($data[0]['prod_nm'])) {
                $entry->nama_model = $data[0]['prod_nm'];
                $entry->save();
            } else {
                $entry->nama_model = null;
                $entry->save();
            }

        }
        $response = $this->traitUpdate();
        return $response;
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
