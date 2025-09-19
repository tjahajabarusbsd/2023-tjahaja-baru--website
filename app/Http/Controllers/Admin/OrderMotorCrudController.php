<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderMotorCRUDRequest;
use App\Models\ActivityLog;
use App\Models\OrderMotor;
use App\Models\UserPublicProfile;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderMotorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderMotorCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(OrderMotor::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order-motor');
        CRUD::setEntityNameStrings('order motor', 'order motors');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('order_id')->label('ID Order');
        CRUD::addColumn([
            'label' => 'Nama',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\Models\UserPublic",
        ]);
        CRUD::addColumn([
            'label' => 'Nomor Handphone',
            'entity' => 'user',
            'attribute' => 'phone_number',
            'model' => "App\Models\UserPublic",
        ]);
        CRUD::column('model');
        CRUD::column('status');

        CRUD::denyAccess(['show']);
        CRUD::denyAccess(['create']);
        CRUD::denyAccess(['delete']);

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
        CRUD::setValidation(OrderMotorCRUDRequest::class);

        CRUD::addField([
            'name' => 'order_id',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>ID Order: </strong>' . $this->crud->getCurrentEntry()->order_id . '</p>',
        ]);
        CRUD::addField([
            'name' => 'name',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nama: </strong>' . optional($this->crud->getCurrentEntry()->user)->name . '</p>',
        ]);
        CRUD::addField([
            'name' => 'phone_number',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Handphone: </strong>' . optional($this->crud->getCurrentEntry()->user)->phone_number . '</p>',
        ]);
        CRUD::addField([
            'name' => 'model',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Model: </strong>' . $this->crud->getCurrentEntry()->model . '</p>',
        ]);
        CRUD::addField([
            'name' => 'warna',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Warna: </strong>' . $this->crud->getCurrentEntry()->warna . '</p>',
        ]);
        CRUD::addField([
            'name' => 'tipe_pembayaran',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Tipe Pembayaran: </strong>' . $this->crud->getCurrentEntry()->tipe_pembayaran . '</p>',
        ]);
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

    public function update()
    {
        $response = $this->traitUpdate();

        $order = $this->crud->entry->fresh();

        if ($order->status === 'completed') {
            $points = 1000;

            ActivityLog::create([
                'user_public_id' => $order->user_public_id,
                'source_type' => OrderMotor::class,
                'source_id' => $order->id,
                'type' => 'order_motor',
                'title' => 'Order motor selesai',
                'description' => 'Order motor <strong>' . $order->model . '</strong> telah selesai.',
                'points' => $points,
                'activity_date' => now(),
            ]);

            // Update poin user
            $user = UserPublicProfile::find($order->user_public_id);
            if ($user) {
                $user->increment('total_points', $points);
            }
        }

        return $response;
    }
}
