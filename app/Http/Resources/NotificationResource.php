<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id' => (string) $this->id,
            'title' => $this->title,
            'message' => $this->description, // mapping ke field message di Flutter
            'time' => $this->created_at->toIso8601String(),
            'relative_time' => $this->created_at->diffForHumans(),
            'isRead' => (bool) $this->is_read,
        ];
    }
}
