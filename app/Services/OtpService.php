<?php

namespace App\Services;

use Carbon\Carbon;

class OtpService
{
    protected int $otpLength = 4;
    protected int $expiryMinutes = 5;

    /**
     * Generate OTP dengan 4 digit, tanpa angka 4.
     */
    public function generateOtpWithoutFour(): string
    {
        $digits = '012356789'; // tanpa 4
        $otp = '';

        for ($i = 0; $i < $this->otpLength; $i++) {
            $otp .= $digits[random_int(0, strlen($digits) - 1)];
        }

        return $otp;
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
        return "Kode OTP Anda adalah: *{$otp}*\n\n"
            . "Berlaku {$this->expiryMinutes} menit. Jangan bagikan ke siapa pun.";
    }
}