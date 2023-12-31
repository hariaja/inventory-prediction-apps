<?php

namespace App\Http\Requests\Masters;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        'required', 'string',
        Rule::unique('products', 'name')->ignore($this->product),
      ],
      'quantity' => 'required|numeric|max:50',
      'quantity_one_day' => 'required|numeric|max:50',
      'produced_at' => 'required|date',
      'description' => 'nullable|string',
      'price' => 'required',
    ];
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      $quantity = $this->input('quantity');
      $quantityOneDay = $this->input('quantity_one_day');

      if ($quantity > $quantityOneDay) {
        $validator->errors()->add('quantity', 'Stok yang tersedia tidak boleh lebih besar dari Jumlah Stok Per Hari.');
      }
    });
  }

  /**
   * Make a capital letter at the end of each word.
   */
  public function validationData()
  {
    $data = $this->all();
    $data['name'] = Str::title($data['name']);
    return $data;
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
      'name' => 'Nama Produk',
      'quantity' => 'Jumlah Produk',
      'quantity_one_day' => 'Jumlah Produk Per Hari',
      'produced_at' => 'Diproduksi Pada',
      'description' => 'Deskripsi',
      'price' => 'Harga Satuan',
    ];
  }
}
