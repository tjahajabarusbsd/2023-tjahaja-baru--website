<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GroupProductSpecRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class GroupProductSpecCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class GroupProductSpecCrudController extends CrudController
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
        CRUD::setModel(\App\Models\GroupProductSpec::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/group-product-spec');
        CRUD::setEntityNameStrings('group product spec', 'group product specs');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('group_id');
        CRUD::column('created_at');
        CRUD::column('updated_at');

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
        CRUD::field('group_id')->tab('Grup');
        CRUD::field('tipe_mesin')->tab('Mesin');
        CRUD::field('jumlah_silinder')->tab('Mesin');
        CRUD::field('volume_silinder')->tab('Mesin');
        CRUD::field('diameter_x_langkah')->tab('Mesin');
        CRUD::field('perbandingan_kompresi')->tab('Mesin');
        CRUD::field('daya_maksimum')->tab('Mesin');
        CRUD::field('torsi_maksimum')->tab('Mesin');
        CRUD::field('sistem_starter')->tab('Mesin');
        CRUD::field('sistem_pelumasan')->tab('Mesin');
        CRUD::field('kapasitas_oli')->tab('Mesin');
        CRUD::field('sistem_bahan_bakar')->tab('Mesin');
        CRUD::field('tipe_kopling')->tab('Mesin');
        CRUD::field('tipe_transmisi')->tab('Mesin');
        CRUD::field('pola_transmisi')->tab('Mesin');
        CRUD::field('tipe_rangka')->tab('Rangka');
        CRUD::field('suspensi_depan')->tab('Rangka');
        CRUD::field('suspensi_belakang')->tab('Rangka');
        CRUD::field('tipe_ban')->tab('Rangka');
        CRUD::field('ban_depan')->tab('Rangka');
        CRUD::field('ban_belakang')->tab('Rangka');
        CRUD::field('rem_depan')->tab('Rangka');
        CRUD::field('rem_belakang')->tab('Rangka');
        CRUD::field('p_l_t')->tab('Dimensi');
        CRUD::field('jarak_sumbu')->tab('Dimensi');
        CRUD::field('jarak_terendah_ketanah')->tab('Dimensi');
        CRUD::field('tinggi_tempat_duduk')->tab('Dimensi');
        CRUD::field('berat_isi')->tab('Dimensi');
        CRUD::field('kapasitas_tangki')->tab('Dimensi');
        CRUD::field('sistem_pengapian')->tab('Kelistrikan');
        CRUD::field('battery')->tab('Kelistrikan');
        CRUD::field('tipe_busi')->tab('Kelistrikan');

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
