<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DealerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DealerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DealerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Dealer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dealer');
        CRUD::setEntityNameStrings('dealer', 'dealers');
    }

    protected function setupListOperation()
    {
        CRUD::column('kode_dealer');
        CRUD::column('name_dealer')->label('Nama Dealer');
        CRUD::column('kecamatan');
        CRUD::column('kota');
        CRUD::column('nohp')->label('No. HP');

        // Kolom bantu: cepat melihat dealer mana yang koordinatnya belum diisi
        CRUD::addColumn([
            'name'  => 'koordinat',
            'label' => 'Koordinat',
            'type'  => 'closure',
            'function' => function ($entry) {
                return ($entry->latitude && $entry->longitude)
                    ? '<span class="text-success">Lengkap</span>'
                    : '<span class="text-danger">Belum diisi</span>';
            },
            'escaped' => false,
        ]);

        CRUD::column('updated_at');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        CRUD::column('address')->label('Alamat');
        CRUD::column('latitude');
        CRUD::column('longitude');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(DealerRequest::class);

        CRUD::field('kode_dealer')->wrapper(['class' => 'form-group col-md-4']);
        CRUD::field('name_dealer')->label('Nama Dealer')->wrapper(['class' => 'form-group col-md-8']);

        CRUD::field('kecamatan')->wrapper(['class' => 'form-group col-md-6']);
        CRUD::field('kota')->wrapper(['class' => 'form-group col-md-6']);

        CRUD::field('address')->type('textarea')->label('Alamat');
        CRUD::field('nohp')->label('No. HP / Telepon');

        CRUD::field('latitude')
            ->type('text')
            ->hint('Contoh: -0.9492. Klik kanan lokasi di Google Maps, lalu klik angka koordinat untuk menyalin.')
            ->wrapper(['class' => 'form-group col-md-6']);
        CRUD::field('longitude')
            ->type('text')
            ->hint('Contoh: 100.3543')
            ->wrapper(['class' => 'form-group col-md-6']);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
