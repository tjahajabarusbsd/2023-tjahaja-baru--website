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
            'id' => $this->id,
            'scan_code' => $this->scan_code,
            'scanned_at' => $this->scanned_at,
            'usage_count' => $this->usage_count,
            'max_usage' => $this->max_usage,

            'qrcode' => [
                'id' => $this->qrcode->id,
                'nama' => $this->qrcode->nama_qrcode,
                'benefit' => $this->qrcode->benefit,
                'max_penggunaan' => $this->qrcode->max_penggunaan,
                'jumlah_penggunaan' => $this->qrcode->jumlah_penggunaan,
                'aktif' => $this->qrcode->aktif,
            ]
        ];
    }
}
