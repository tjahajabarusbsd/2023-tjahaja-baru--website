<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BookingServiceCRUDRequest;
use App\Models\ActivityLog;
use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\UserPublicProfile;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BookingServiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BookingServiceCrudController extends CrudController
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
        CRUD::setModel(BookingService::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/booking-service');
        CRUD::setEntityNameStrings('booking service', 'booking services');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('booking_id')->label('ID Booking');
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
        CRUD::column('motor_id')->label('Nomor Rangka');
        CRUD::addColumn([
            'label' => 'Dealer',
            'entity' => 'dealer',
            'attribute' => 'name_dealer',
            'model' => "App\Models\Dealer",
        ]);
        CRUD::column('status');

        // Hilangkan tombol preview
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
        CRUD::setValidation(BookingServiceCRUDRequest::class);

        CRUD::addField([
            'name' => 'booking_id',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>ID Booking: </strong>' . $this->crud->getCurrentEntry()->booking_id . '</p>',
        ]);

        CRUD::addField([
            'name' => 'user_id',
            'label' => 'User',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nama: </strong>' . optional($this->crud->getCurrentEntry()->user)->name . '</p>',
        ]);

        CRUD::addField([
            'name' => 'phone_number',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Handphone: </strong>' . optional($this->crud->getCurrentEntry()->user)->phone_number . '</p>',
        ]);

        CRUD::addField([
            'name' => 'motor_id',
            'label' => 'Nomor Rangka',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Rangka: </strong>'
                . optional($this->crud->getCurrentEntry()->motor)->nomor_rangka
                . '</p>'
        ]);

        CRUD::addField([
            'name' => 'dealer',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Dealer: </strong>'
                . optional($this->crud->getCurrentEntry()->dealer)->name_dealer
                . '</p>'
        ]);

        CRUD::addField([
            'name' => 'tanggal',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Tanggal Servis: </strong>'
                . \Carbon\Carbon::parse($this->crud->getCurrentEntry()->tanggal)->format('d/m/Y')
                . '</p>',
        ]);

        CRUD::addField([
            'name' => 'jam',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Jam Servis: </strong>'
                . $this->crud->getCurrentEntry()->jam
                . '</p>'
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

        $booking = $this->crud->entry;

        // ambil user publik dari booking
        $user = \App\Models\UserPublic::find($booking->user_id);

        // ambil motor yang sesuai dengan booking
        $motor = NomorRangka::where('id', $booking->motor_id)
            ->where('user_public_id', $user->id)
            ->first();

        if ($booking->status === 'completed') {
            $points = 100;

            // buat activity log baru
            ActivityLog::create([
                'user_public_id' => $user->id,
                'source_type' => BookingService::class,
                'source_id' => $booking->id,
                'type' => 'services',
                'title' => 'Servis selesai',
                'description' => 'Booking servis untuk motor ' . ($motor ? $motor->nama_model : '-'),
                'points' => $points,
                'activity_date' => now(),
            ]);

            // update total points user
            // update total_points di profile
            $profile = UserPublicProfile::where('user_public_id', $user->id)->first();
            if ($profile) {
                $profile->increment('total_points', $points);
            }
        }

        return $response;
    }

}
