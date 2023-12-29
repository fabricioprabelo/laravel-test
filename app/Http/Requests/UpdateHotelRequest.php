<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
                'max:255',
                Rule::unique('hotels')->ignore($this->route('hotel')->id)
            ],
            'address' => 'required|max:255',
            'complement' => 'max:255',
            'neighborhood' => 'max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'zip_code' => 'required|max:255',
            'website' => 'url|max:255',
            'rooms' => "array",
            'rooms.*.name' => "required|max:255",
            'rooms.*.description' => "max:255",
        ];
    }
}
