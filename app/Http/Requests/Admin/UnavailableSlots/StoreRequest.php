<?php

namespace App\Http\Requests\Admin\UnavailableSlots;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // In the future we could use a policy check if there were more users in the system
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'startAt' => [
                'required',
                'date',
            ],
            'endAt' => [
                'required',
                'date',
                'after:startAt',
            ],
        ];
    }
}
