<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWatchlistRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'commodity_codes' => ['required', 'array', 'min:1'],
            'commodity_codes.*' => [
                'required',
                'string',
                Rule::exists('commodities', 'code')->where('is_active', true),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'commodity_codes.required' => 'Pilih minimal satu komoditas pantauan.',
            'commodity_codes.min' => 'Pilih minimal satu komoditas pantauan.',
            'commodity_codes.*.exists' => 'Komoditas yang dipilih tidak valid atau tidak aktif.',
        ];
    }
}
