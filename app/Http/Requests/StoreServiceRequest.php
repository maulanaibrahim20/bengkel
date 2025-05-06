<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:services,name',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:100',
            'icon' => 'nullable|string|max:255',
            'details' => 'required|array|min:1',
            'details.*' => 'required|string|min:3|max:255|distinct'
        ];
    }

    public function messages()
    {
        return [
            'details.required' => 'Minimal 1 deskripsi layanan harus diisi.',
            'details.*.distinct' => 'Deskripsi layanan tidak boleh duplikat.',
            'details.*.min' => 'Deskripsi layanan minimal terdiri dari :min karakter.',
        ];
    }
}
