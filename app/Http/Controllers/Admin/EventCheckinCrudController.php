<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventCheckin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Daftar peserta check-in event (read-only + export).
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventCheckinCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup(): void
    {
        CRUD::setModel(EventCheckin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/event-checkin');
        CRUD::setEntityNameStrings('Peserta Event', 'Peserta Event');

        $this->crud->denyAccess(['create', 'update']);
        $this->crud->addClause('with', ['event', 'user']);
    }

    protected function setupListOperation(): void
    {
        CRUD::addColumn([
            'name' => 'event_id',
            'type' => 'relationship',
            'label' => 'Event',
            'entity' => 'event',
            'attribute' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'user_public_id',
            'type' => 'relationship',
            'label' => 'Nama',
            'entity' => 'user',
            'attribute' => 'name',
        ]);

        CRUD::addColumn([
            'name' => 'phone_number',
            'label' => 'No. HP',
            'type' => 'closure',
            'function' => fn ($entry) => $entry->user?->phone_number ?? '-',
        ]);

        CRUD::addColumn([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'closure',
            'function' => fn ($entry) => $entry->user?->email ?? '-',
        ]);

        CRUD::addColumn([
            'name' => 'checkin_code',
            'label' => 'Kode Tiket',
            'type' => 'text',
        ]);

        CRUD::addColumn([
            'name' => 'checked_in_at',
            'label' => 'Waktu Check-in',
            'type' => 'datetime',
        ]);

        // Filter per event
        CRUD::addFilter([
            'type' => 'select2',
            'name' => 'event_id',
            'label' => 'Event',
        ], function () {
            return Event::orderByDesc('start_date')->pluck('name', 'id')->toArray();
        }, function ($value) {
            CRUD::addClause('where', 'event_id', $value);
        });

        // Filter rentang tanggal check-in
        CRUD::addFilter([
            'type' => 'date_range',
            'name' => 'checked_in_range',
            'label' => 'Tanggal Check-in',
        ], false, function ($value) {
            $dates = json_decode($value);

            if (! empty($dates->from)) {
                CRUD::addClause('where', 'checked_in_at', '>=', $dates->from);
            }

            if (! empty($dates->to)) {
                CRUD::addClause('where', 'checked_in_at', '<=', $dates->to . ' 23:59:59');
            }
        });

        CRUD::enableExportButtons();
    }
}
