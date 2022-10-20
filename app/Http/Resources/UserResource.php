<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'phone'  => $this->phone,
            'email'  => $this->email,
            'status' => $this->status,
            'photo'  => $this->photo,
        ];
    }
}
