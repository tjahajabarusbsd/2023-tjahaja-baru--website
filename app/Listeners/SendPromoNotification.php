<?php

namespace App\Listeners;

use App\Models\Promo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;
use App\Services\Notification\FcmService;

class SendPromoNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $promo = $event->promo;

        Notification::create([
            'user_public_id' => null,
            'source_type' => Promo::class,
            'source_id' => $promo->id,
            'category' => 'Promo',
            'title' => $promo->name,
            'description' => 'Promo baru tersedia',
            'is_read' => false,
        ]);

        // ✅ Kirim ke FCM Topic
        app(FcmService::class)->sendToTopic(
            'promo', // nama topic
            'Promo Baru!',
            $promo->name
        );
    }
}
