<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\PhoneChangeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class OtpService
{
    protected int $otpLength = 4;
    protected int $expiryMinutes = 5;

    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function generateOtpWithoutFour(): string
    {
        $digits = '012356789';
        $otp = '';

        for ($i = 0; $i < $this->otpLength; $i++) {
            $otp .= $digits[random_int(0, strlen($digits) - 1)];
        }

        return $otp;
    }

    public function hashOtp(string $otp): string
    {
        return Hash::make($otp);
    }

    public function expiryTime(): Carbon
    {
        return Carbon::now()->addMinutes($this->expiryMinutes);
    }

    public function getExpirySeconds(): int
    {
        return $this->expiryMinutes * 60;
    }

    public function buildMessage(string $otp): string
    {
        return "Kode OTP Anda adalah: *{$otp}*. "
            . "Berlaku {$this->expiryMinutes} menit. Jangan bagikan ke siapa pun.";
    }

    public function sendOtp($user, string $type, string $phone)
    {
        $otpPlain = $this->generateOtpWithoutFour();
        $otpHash = $this->hashOtp($otpPlain);
        $expiry = $this->expiryTime();

        DB::transaction(function () use ($user, $type, $phone, $otpHash, $expiry) {

            if ($type === 'register' || $type === 'forgot_password') {
                $user->update([
                    'otp' => $otpHash,
                    'otp_expires_at' => $expiry,
                    'last_otp_sent_at' => now(),
                ]);
            }

            if ($type === 'change_phone') {
                PhoneChangeRequest::updateOrCreate(
                    ['user_public_id' => $user->id],
                    [
                        'new_phone_number' => $phone,
                        'otp' => $otpHash,
                        'otp_expires_at' => $expiry,
                        'last_otp_sent_at' => now(),
                        'status' => 'pending',
                    ]
                );
            }
        });

        $message = $this->buildMessage($otpPlain);
        $apiResponse = $this->whatsAppService->send($phone, $message);

        if ($apiResponse->failed()) {
            Log::error('WhatsApp API gagal', [
                'user_id' => $user->id,
                'phone' => $phone,
                'type' => $type,
            ]);

            throw new Exception('WhatsApp API call failed.');
        }
    }
}