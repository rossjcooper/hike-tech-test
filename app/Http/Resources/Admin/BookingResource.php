<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->getRouteKey(),
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'startAt' => $this->start_at,
            'vehicleMake' => $this->vehicle_make,
            'vehicleModel' => $this->vehicle_model,
        ];
    }
}
