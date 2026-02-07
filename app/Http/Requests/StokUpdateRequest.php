<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * StokUpdateRequest
 *
 * Stok güncelleme validasyonu
 */
class StokUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'SFIRMAID' => ['nullable', 'integer'],
            'STOKKOD' => ['sometimes', 'required', 'string', 'max:50'],
            'STOKADI' => ['sometimes', 'required', 'string', 'max:255'],
            'ETICARETKOD' => ['nullable', 'string', 'max:100'],
            'STOKADI_PRKND' => ['nullable', 'string', 'max:255'],
            'STOKGRP1' => ['nullable', 'string', 'max:50'],
            'STOKGRP2' => ['nullable', 'string', 'max:50'],
            'STKDV' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'STKDV2' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'STALISFIYAT' => ['nullable', 'numeric', 'min:0'],
            'STSATISFIYAT1' => ['nullable', 'numeric', 'min:0'],
            'STSATISFIYAT2' => ['nullable', 'numeric', 'min:0'],
            'STKRITIK' => ['nullable', 'numeric', 'min:0'],
            'STBIRIM' => ['nullable', 'string', 'max:20'],
            'STBIRIM2' => ['nullable', 'string', 'max:20'],
            'STBIRIM2KATSAYI' => ['nullable', 'numeric', 'min:0'],
            'STISKONTO' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
