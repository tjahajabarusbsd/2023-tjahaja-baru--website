<?php

namespace App\Console\Commands;

use App\Services\Booking\ServiceReminderService;
use Illuminate\Console\Command;

class SendServiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:service-reminder
                            {--user= : Batasi pengingat ke user_public_id tertentu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi pengingat servis 60/30/15 menit sebelum jam booking (status confirmed)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ServiceReminderService $reminderService)
    {
        $userId = $this->option('user');

        $sent = $reminderService->sendDueReminders(
            $userId !== null ? (int) $userId : null
        );

        if (empty($sent)) {
            $this->info('Tidak ada pengingat servis yang jatuh tempo.');

            return 0;
        }

        foreach ($sent as $item) {
            $this->info(sprintf(
                '✅ Pengingat %d menit terkirim | booking #%s | user %s',
                $item['stage_minutes'],
                $item['booking_code'],
                $item['user_public_id']
            ));
        }

        $this->info('Total pengingat terkirim: ' . count($sent));

        return 0;
    }
}
