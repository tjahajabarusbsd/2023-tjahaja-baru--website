<?php

namespace App\Listeners;

use App\Models\Promo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;
use App\Models\UserPublic;
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
        $now = now();

        $rows = UserPublic::pluck('id')->map(fn($id) => [
            'user_public_id' => $id,
            'source_type' => Promo::class,
            'source_id' => $promo->id,
            'category' => 'Promo',
            'title' => $promo->name,
            'description' => 'Promo baru tersedia',
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ])->toArray();

        // insert per-chunk biar query tidak terlalu besar sekali jalan
        foreach (array_chunk($rows, 500) as $chunk) {
            Notification::insert($chunk);
        }

        app(FcmService::class)->sendToTopic(
            'promo',
            'Promo Baru!',
            "{$promo->merchant->title}: {$promo->name}",
            [
                'type' => 'promo',
                'promo_id' => (string) $promo->id,
            ]
        );
    }
}
