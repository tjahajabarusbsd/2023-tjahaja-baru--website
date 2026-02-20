<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QrScanLogDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'scan_id' => $this->scan_code,
            'nama_qrcode' => $this->qrcode->nama_qrcode,
            'merchant_name' => $this->qrcode->merchant->title,
            'user_name' => $this->user->name,
            'usage_count' => $this->usage_count,
            'max_usage' => $this->max_usage,
            'scanned_at' => $this->scanned_at->format('d/m/Y H:i'),
        ];
    }
}
