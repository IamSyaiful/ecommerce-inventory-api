<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah ke true agar request diizinkan
    }

    public function rules(): array
    {
        return [
            // Validasi: wajib diisi, string, maksimal 255 karakter, dan unik di tabel category_products
            'name' => 'required|string|max:255|unique:category_products,name',
        ];
    }
}