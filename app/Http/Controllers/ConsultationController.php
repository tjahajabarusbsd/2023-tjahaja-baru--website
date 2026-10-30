<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationRequest;
use App\Models\Consultation;
use App\Models\Staff;
use App\Models\Variant;
use App\Support\CroRotation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Throwable;

class ConsultationController extends Controller
{
    private const RECAPTCHA_ACTION = 'contact';

    // Skor di bawah atau sama dengan nilai ini dianggap bot (Google menyarankan 0.5 sebagai awal)
    private const RECAPTCHA_MIN_SCORE = 0.7;

    private const DP_RANGES = [
        'dp-0' => 'Rp. 1 Juta - 5 Juta',
        'dp-1' => 'Rp. 5 Juta - 10 Juta',
        'dp-2' => 'Rp. 10 Juta - 15 Juta',
    ];

    private const DP_ABOVE_RANGES = 'Diatas Rp 15 juta';

    public function getConsultationForm(Request $request): View
    {
        $value = $request->query('sales');

        // Cookie 'sales' hanya diset bila ada parameter; tidak pernah dihapus dari sini
        if (filled($request->input('sales'))) {
            Cookie::queue('sales', $request->input('sales'));
        }

        $lists = Variant::query()->select('name')->distinct()->orderBy('name')->get();

        return view('consultation', compact('value', 'lists'));
    }

    public function submitConsultationForm(
        ConsultationRequest $request,
        WhatsAppController $whatsAppController
    ): JsonResponse {
        if (! $this->passesRecaptcha($request)) {
            return response()->json(['errorMessage' => 'Anda kemungkinan adalah bot'], 400);
        }

        $validatedData = $request->validated();

        // Sales code dari cookie hanya dipakai kalau memang terdaftar sebagai staff
        $cookieCode = $request->cookie('sales');
        $staff = $this->findStaff($cookieCode);
        $salesCode = $staff ? $cookieCode : null;

        $dp = $validatedData['dp'] ?? null;
        $dpValue = $dp !== null ? (self::DP_RANGES[$dp] ?? self::DP_ABOVE_RANGES) : null;

        $consultation = Consultation::storeSubmission(
            $validatedData,
            $dpValue,
            $this->sourcePath($request->input('url')),
            $salesCode,
            $request->cookie('utm_campaign')
        );

        $sent = $this->sendToWhatsApp(
            $whatsAppController,
            $this->recipientPhone($staff),
            $this->buildMessageBody($validatedData, $dpValue)
        );

        if (! $sent) {
            $consultation->delete();

            return response()->json(['errorMessage' => 'Pesan gagal terkirim!'], 422);
        }

        return response()
            ->json(['successMessage' => "Pengajuan Anda telah diterima.\nDealer kami akan segera menghubungi Anda."], 201)
            ->withCookie(Cookie::forget('utm_campaign'));
    }

    private function passesRecaptcha(Request $request): bool
    {
        $score = RecaptchaV3::verify($request->input('g-recaptcha-response'), self::RECAPTCHA_ACTION);

        if ($score > self::RECAPTCHA_MIN_SCORE) {
            return true;
        }

        // Catatan skor membantu menilai apakah ambang terlalu tinggi untuk pengunjung asli
        Log::info('Konsultasi ditolak reCAPTCHA', ['score' => $score, 'ip' => $request->ip()]);

        return false;
    }

    // Satu query, dan tidak pernah mencari "code IS NULL" kalau cookie kosong
    private function findStaff(mixed $code): ?Staff
    {
        if (! is_string($code) || $code === '') {
            return null;
        }

        return Staff::where('code', $code)->first();
    }

    private function recipientPhone(?Staff $staff): string
    {
        $phone = $staff?->phone;

        if (filled($phone)) {
            return str_replace('+', '', $phone);
        }

        // Lead tanpa sales: nomor CRO yang bertugas hari ini (bergantian per hari)
        return CroRotation::forDate(now());
    }

    /*
     * Halaman asal form, format "path?query" sama seperti sebelumnya
     * (termasuk "?" di akhir bila tanpa query). Aman untuk URL kosong atau rusak.
     */
    private function sourcePath(mixed $url): string
    {
        $parts = parse_url((string) $url) ?: [];

        return ($parts['path'] ?? '/') . '?' . ($parts['query'] ?? '');
    }

    // Kegagalan apa pun (status bukan 200 atau exception) dianggap gagal kirim
    private function sendToWhatsApp(WhatsAppController $whatsApp, string $phone, string $message): bool
    {
        try {
            $status = $whatsApp->sendWhatsAppMessage($phone, $message)->getStatusCode();
        } catch (Throwable $e) {
            Log::error('Kirim WhatsApp konsultasi gagal', ['error' => $e->getMessage()]);

            return false;
        }

        if ($status !== 200) {
            Log::warning('WhatsApp konsultasi tidak berstatus 200', ['status' => $status]);
        }

        return $status === 200;
    }

    private function buildMessageBody(array $validatedData, ?string $dpValue): string
    {
        $messageBody = [
            'Berikut ini data konsumen yang mengisi form di website kita yang minat dengan produk Yamaha: ',
            '*Nama:* ' . $validatedData['name'] . ', ',
            '*No HP:* ' . $validatedData['nohp'] . ', ',
            '*Produk yang diminati:* ' . $validatedData['produk'] . ', ',
        ];

        if ($validatedData['cara_bayar'] === 'kredit') {
            $messageBody[] = '*Cara bayar:* ' . $validatedData['cara_bayar'] . ', ';
            $messageBody[] = '*DP:* ' . $dpValue . ', ';
            $messageBody[] = '*Tenor:* ' . $validatedData['tenor'] . ' bulan ' . '. ';
        }

        if ($validatedData['cara_bayar'] === 'cash') {
            $messageBody[] = '*Cara bayar:* ' . $validatedData['cara_bayar'] . '. ';
        }

        $messageBody[] = 'Tolong segera diproses. Terima kasih.';

        return implode('', $messageBody);
    }
}
