<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:category_products,id',
        ];
    }

    public function messages()
    {
        return [
            'price.min' => 'Harga produk tidak boleh negatif.',
            'stock_quantity.min' => 'Stok produk tidak boleh negatif.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid atau tidak ditemukan.',
        ];
    }
}
