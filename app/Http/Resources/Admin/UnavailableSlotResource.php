<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UnavailableSlotResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->getRouteKey(),
            'startAt' => $this->start_at->toISOString(),
            'endAt' => $this->end_at->toISOString(),
        ];
    }
}
