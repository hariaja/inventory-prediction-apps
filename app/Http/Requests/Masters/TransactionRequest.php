<?php

namespace App\Http\Requests\Masters;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
      'product_id' => 'required|exists:products,id',
      'quantity' => 'required|numeric|max:25',
    ];
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      $productId = $this->input('product_id');
      $quantity = $this->input('quantity');

      if ($productId && $quantity) {
        $product = Product::find($productId);

        if (!$product || $quantity > $product->quantity) {
          $validator->errors()->add('quantity', 'Jumlah tidak boleh melebihi stok yang tersedia.');
        }
      }
    });
  }

  /**
   * Get the error messages for the defined validation rules.
   */
  public function messages(): array
  {
    return [
      '*.required' => ':attribute harus tidak boleh dikosongkan',
      '*.max' => ':attribute melebihi batas, maksimal :max',
      '*.in' => ':attribute harus salah satu dari data berikut: :values',
      '*.unique' => ':attribute sudah digunakan, silahkan pilih yang lain',
      '*.date' => ':attribute Harus berupa tanggal',
      '*.exists' => ':attribute tidak ditemukan atau tidak bisa diubah',
      '*.numeric' => ':attribute input tidak valid atau harus berupa angka',
    ];
  }

  /**
   * Get the validation attribute names that apply to the request.
   *
   * @return array<string, string>
   */
  public function attributes(): array
  {
    return [
      'product_id' => 'Nama Produk',
      'quantity' => 'Jumlah Terjual',
    ];
  }
}
