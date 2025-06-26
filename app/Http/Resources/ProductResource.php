<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'uri' => $this->uri,
            'image' => asset($this->image),
            'logo' => "https://duckdumber.com/logoNmax1.png",
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
