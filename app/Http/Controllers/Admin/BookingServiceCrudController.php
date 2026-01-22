<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\BookingServiceCRUDRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\ActivityLog;
use App\Models\BookingService;
use App\Models\NomorRangka;
use App\Models\UserPublicProfile;
use App\Models\Notification;
use App\Models\UserPublic;
use Illuminate\Validation\ValidationException;

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
        // CRUD::column('booking_id')->label('ID Booking');
        // tanggal dan jam dipisah
        CRUD::addColumn([
            'name' => 'tanggal',
            'label' => 'Tanggal Servis',
            'type' => 'date',
            'format' => 'DD/MM/YYYY',
        ]);

        CRUD::addColumn([
            'name' => 'jam',
            'label' => 'Jam Servis',
            'type' => 'time',
            'format' => 'H:i',
        ]);

        // nomor plat ditambahkan
        CRUD::addColumn([
            'name' => 'nomor_plat',
            'label' => 'Nomor Plat',
            'type' => 'closure',
            'function' => function ($entry) {
                $motor = $entry->motor;
                return $motor ? $motor->nomor_plat : '-';
            },
        ]);

        // nama model
        CRUD::addColumn([
            'name' => 'nama_model',
            'label' => 'Brand Motor',
            'type' => 'closure',
            'function' => function ($entry) {
                $motor = $entry->motor;
                return $motor ? $motor->nama_model : '-';
            },
        ]);

        CRUD::addColumn([
            'label' => 'Nomor Handphone',
            'entity' => 'user',
            'attribute' => 'phone_number',
            'model' => "App\Models\UserPublic",
        ]);

        CRUD::addColumn([
            'label' => 'Nama',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\Models\UserPublic",
        ]);

        // CRUD::column('motor_id')->label('Nomor Rangka');
        // CRUD::addColumn([
        //     'label' => 'Dealer',
        //     'entity' => 'dealer',
        //     'attribute' => 'name_dealer',
        //     'model' => "App\Models\Dealer",
        // ]);
        CRUD::column('status');
        CRUD::enableExportButtons();

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
            'value' => '<p style="margin-bottom:0"><strong>Nama Customer: </strong>' . optional($this->crud->getCurrentEntry()->user)->name . '</p>',
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
            'name' => 'Plat_no',
            'label' => 'Nomor Plat',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Nomor Plat: </strong>'
                . optional($this->crud->getCurrentEntry()->motor)->nomor_plat
                . '</p>'
        ]);

        CRUD::addField([
            'name' => 'Brand_id',
            'label' => 'Brand Motor',
            'type' => 'custom_html',
            'value' => '<p style="margin-bottom:0"><strong>Brand Motor: </strong>'
                . optional($this->crud->getCurrentEntry()->motor)->nama_model
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

        // CRUD::addField([
        //     'name' => 'jam',
        //     'type' => 'custom_html',
        //     'value' => '<p style="margin-bottom:0"><strong>Jam Servis: </strong>'
        //         . $this->crud->getCurrentEntry()->jam
        //         . '</p>'
        // ]);

        // make crud time
        CRUD::addField([
            'name' => 'jam',
            'type' => 'time',
            'label' => 'Jam Servis',
            'attributes' => [
                'step' => '900', // 15 menit dalam detik
            ],
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
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
        // Ambil booking sebelum update untuk tahu old status
        $bookingId = $this->crud->getCurrentEntryId();
        $bookingBefore = $this->crud->model->find($bookingId);
        $oldStatus = $bookingBefore ? $bookingBefore->status : null;

        // Ambil status baru dari request admin
        $newStatus = request()->input('status');

        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];

        if ($oldStatus !== null) {
            $allowed = $allowedTransitions[$oldStatus] ?? null;

            if (!in_array($newStatus, $allowed)) {

                \Alert::error("Transisi dari <b>{$oldStatus}</b> ke <b>{$newStatus}</b> tidak diizinkan.")
                    ->flash();

                throw ValidationException::withMessages([
                    'status' => "Transisi tidak diizinkan."
                ]);

            }
        }

        // Lakukan update default Backpack (ini akan mengubah $this->crud->entry)
        $response = $this->traitUpdate();

        // Ambil booking setelah update
        $booking = $this->crud->entry;
        $newStatus = $booking ? $booking->status : null;

        // Ambil user & motor (safe guard kalau null)
        $user = ($booking && $booking->user_id)
            ? UserPublic::find($booking->user_id)
            : null;

        $motor = ($booking && $user)
            ? NomorRangka::where('id', $booking->motor_id)
                ->where('user_public_id', $user->id)
                ->first()
            : null;

        if ($oldStatus === $newStatus) {
            return $response;
        }

        // Persiapkan payload notifikasi untuk dikirim setelah commit
        $afterCommitJobs = [];

        try {
            if ($newStatus === 'cancelled') {
                DB::transaction(function () use ($user, $booking, $motor) {
                    if ($user) {
                        Notification::create([
                            'user_public_id' => $user->id,
                            'source_type' => BookingService::class,
                            'source_id' => $booking->id,
                            'title' => 'Booking Servis Dibatalkan.',
                            'description' => 'Booking servis untuk motor ' . ($motor ? $motor->nama_model : '-') . ' telah dibatalkan.',
                            'is_read' => false,
                        ]);
                    }
                });

                if ($user && $user->fcm_token) {
                    $afterCommitJobs[] = function () use ($user, $motor) {
                        $this->sendFcmNotification(
                            $user->fcm_token,
                            'Booking Servis Dibatalkan ❌',
                            'Booking servis untuk motor ' . ($motor ? $motor->nama_model : '-') . ' telah dibatalkan.'
                        );
                    };
                }
            }

            if ($newStatus === 'confirmed') {
                DB::transaction(function () use ($user, $booking, $motor) {
                    if ($user) {
                        Notification::create([
                            'user_public_id' => $user->id,
                            'source_type' => BookingService::class,
                            'source_id' => $booking->id,
                            'title' => 'Booking Servis Dikonfirmasi.',
                            'description' => 'Booking servis untuk motor ' . ($motor ? $motor->nama_model : '-') . ' telah dikonfirmasi. Sampai jumpa di dealer!',
                            'is_read' => false,
                        ]);
                    }
                });

                if ($user && $user->fcm_token) {
                    $afterCommitJobs[] = function () use ($user, $motor) {
                        $this->sendFcmNotification(
                            $user->fcm_token,
                            'Booking Servis Dikonfirmasi ✅',
                            'Booking servis untuk motor ' . ($motor ? $motor->nama_model : '-') . ' telah dikonfirmasi. Sampai jumpa di dealer!'
                        );
                    };
                }
            }

            if ($newStatus === 'completed') {
                $points = 0; // sudah tidak pakai poin lagi

                DB::transaction(function () use ($user, $booking, $motor, $points) {
                    if (!$user) {
                        return;
                    }

                    // if (!is_null($booking->points_awarded_at)) {
                    //     Log::info("Poin sudah pernah diberikan untuk booking_id={$booking->id}");
                    //     return;
                    // }

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

                    // Ambil profile + lock for update untuk mencegah race condition
                    // $profile = UserPublicProfile::where('user_public_id', $user->id)
                    //     ->lockForUpdate()
                    //     ->first();

                    // if ($profile) {
                    //     $profile->increment('total_points', $points);
                    //     $profile->increment('lifetime_points', $points);
                    // } else {
                    //     Log::warning("UserPublicProfile not found for user_public_id={$user->id} when awarding points for booking {$booking->id}");
                    // }

                    Notification::create([
                        'user_public_id' => $user->id,
                        'source_type' => BookingService::class,
                        'source_id' => $booking->id,
                        'title' => 'Servis Selesai.',
                        'description' => 'Servis motor Anda telah selesai.',
                        'is_read' => false,
                    ]);

                    // $booking->update([
                    //     'points_awarded_at' => now(),
                    // ]);
                });

                if ($user && $user->fcm_token) {
                    $afterCommitJobs[] = function () use ($user, $motor) {
                        $this->sendFcmNotification(
                            $user->fcm_token,
                            'Servis Selesai ✅',
                            'Servis untuk motor ' . ($motor ? $motor->nama_model : '-') . ' telah selesai.'
                        );
                    };
                }
            }

            // Jalankan semua afterCommit jobs hanya setelah DB commit
            if (!empty($afterCommitJobs)) {
                DB::afterCommit(function () use ($afterCommitJobs) {
                    foreach ($afterCommitJobs as $job) {
                        try {
                            // job adalah closure yang memanggil sendFcmNotification
                            $job();
                        } catch (\Throwable $e) {
                            // Jangan crash request kalau FCM gagal; log saja
                            Log::error('FCM after commit failed: ' . $e->getMessage(), [
                                'exception' => $e,
                            ]);
                        }
                    }
                });
            }
        } catch (\Throwable $ex) {
            Log::error("Error processing booking side-effects for booking_id={$bookingId}: " . $ex->getMessage(), [
                'exception' => $ex,
            ]);
        }

        return $response;
    }

    /**
     * Kirim notifikasi FCM v1
     */
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
