<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserImportRequest extends FormRequest
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
            'file' => 'required|mimes:xlsx,xls',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Excel dosyası seçilmelidir.',
            'file.mimes' => 'Geçerli bir Excel dosyası seçiniz (xlsx veya xls formatında).',
        ];
    }
}
