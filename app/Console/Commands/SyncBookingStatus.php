<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingService;
use App\Services\BookingStatusSyncService;

class SyncBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync booking status from DPACK via N8N and notify users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(BookingStatusSyncService $syncService)
    {
        $this->info('⏳ Sync booking status started');

        $bookings = BookingService::whereIn('status', [
            'pending',
            'booking',
            'confirmed'
        ])
            ->get();

        foreach ($bookings as $booking) {
            $syncService->syncByBooking($booking);
        }

        $this->info('✅ Sync booking status finished');
        return 0;
    }
}
