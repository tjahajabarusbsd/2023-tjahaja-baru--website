<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NomorRangkaRequest;
use App\Models\NomorRangka;
use App\Models\Notification;
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
        CRUD::addColumn([
            'label' => 'Nama',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\Models\UserPublic",
        ]);
        CRUD::column('nomor_rangka');
        CRUD::column('status_verifikasi')->type('enum')->options([
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected'
        ]);

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
        CRUD::setValidation(NomorRangkaRequest::class);

        CRUD::addField([
            'name' => 'user_public_id',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nama: </strong>' . optional($this->crud->getCurrentEntry()->user)->name . '</p>',
        ]);

        CRUD::addField([
            'name' => 'phone_numbers',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Handphone yang terdaftar di aplikasi: </strong>' . optional($this->crud->getCurrentEntry()->user)->phone_number . '</p>',
        ]);

        CRUD::addField([
            'name' => 'nomor_rangka',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Rangka: </strong>' . $this->crud->getCurrentEntry()->nomor_rangka . '</p>',
        ]);

        CRUD::addField([
            'name' => 'phone_number',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Handphone yang tercatat saat pembelian: </strong>' . $this->crud->getCurrentEntry()->phone_number . '</p>',
        ]);

        $this->crud->addField([
            'name' => 'ktp',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>KTP: </strong><br/><img src="' . asset($this->crud->getCurrentEntry()->ktp) . '">',
        ]);

        $this->crud->addField([
            'name' => 'kk',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>KK: </strong><br/><img src="' . asset($this->crud->getCurrentEntry()->kk) . '">',
        ]);

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
            $secret = env('SECRET_RIWAYAT_SERVICE');
            $now = date('Y_m_d');
            $token = md5($now . $secret);

            // Request ke API eksternal
            $response = Http::withoutVerifying()->withHeaders([
                'X-XSRF-TOKEN' => $token
            ])->get($apiUrl);
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

            $this->sendFcmNotification(
                $entry->user->fcm_token,
                'Verifikasi Nomor Rangka Berhasil',
                'Nomor rangka Anda telah berhasil diverifikasi.'
            );

            Notification::create([
                'user_public_id' => $entry->user_public_id,
                'source_type' => NomorRangka::class,
                'source_id' => $entry->id,
                'category' => 'Nomor Rangka',
                'title' => 'Verifikasi Nomor Rangka Berhasil',
                'description' => 'Nomor rangka Anda telah berhasil diverifikasi.',
                'is_read' => false,
            ]);
        }

        if ($oldStatus === 'pending' && $newStatus === 'rejected') {
            $this->sendFcmNotification(
                $entry->user->fcm_token,
                'Verifikasi Nomor Rangka Ditolak',
                'Nomor rangka Anda gagal diverifikasi. Silakan periksa kembali dokumen yang diunggah.'
            );

            Notification::create([
                'user_public_id' => $entry->user_public_id,
                'source_type' => NomorRangka::class,
                'source_id' => $entry->id,
                'title' => 'Verifikasi Nomor Rangka Ditolak',
                'description' => 'Nomor rangka Anda gagal diverifikasi. Silakan periksa kembali dokumen yang diunggah.',
                'is_read' => false,
            ]);
        }

        $response = $this->traitUpdate();
        return $response;
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function sendFcmNotification($deviceToken, $title, $body)
    {
        if (!$deviceToken) {
            \Log::warning('User tidak punya FCM token, notifikasi tidak dikirim.');
            return;
        }

        try {
            $factory = (new \Kreait\Firebase\Factory)
                ->withServiceAccount(config('services.firebase.credentials.file'));

            $messaging = $factory->createMessaging();

            $message = [
                'token' => $deviceToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'default',
                    ],
                ],
            ];

            $messaging->send($message);

            \Log::info("FCM notification sent to user ID {$deviceToken}");
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim FCM notifikasi: ' . $e->getMessage());
        }
    }
}
