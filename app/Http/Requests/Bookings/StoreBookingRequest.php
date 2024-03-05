<?php

namespace App\Http\Requests\Bookings;

use App\Rules\ValidBookingStartAtRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            'date' => [
                'bail',
                'required',
                'date',
                'after:now',
                new ValidBookingStartAtRule(),
            ],
            'vehicleMake' => [
                'required',
                'string',
                'max:255',
            ],
            'vehicleModel' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
