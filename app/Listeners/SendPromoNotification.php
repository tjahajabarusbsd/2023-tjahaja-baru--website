<?php

namespace App\Listeners;

use App\Services\Notification\FcmService;

class SendPromoNotification
{
    public function handle($event)
    {
        $promo = $event->promo;

        app(FcmService::class)->sendToTopic(
            'promo',
            "Promo Baru dari {$promo->merchant->title}",
            $promo->name
        );
    }
}
