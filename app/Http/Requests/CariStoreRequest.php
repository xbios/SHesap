<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CariStoreRequest
 *
 * Cari oluşturma validasyonu
 */
class CariStoreRequest extends FormRequest
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
            'CRKOD' => ['required', 'string', 'max:50'],
            'CRISIM' => ['required', 'string', 'max:255'],
            'CRADRES' => ['nullable', 'string', 'max:500'],
            'CRSEHIR' => ['nullable', 'string', 'max:100'],
            'CRTEL' => ['nullable', 'string', 'max:20'],
            'CRTEL2' => ['nullable', 'string', 'max:20'],
            'CRGSM' => ['nullable', 'string', 'max:20'],
            'CREMAIL' => ['nullable', 'email', 'max:100'],
            'WEBSIFRE' => ['nullable', 'string', 'max:100'],
            'CRYETKILI' => ['nullable', 'string', 'max:100'],
            'CRROTA' => ['nullable', 'string', 'max:50'],
            'CRVERGD' => ['nullable', 'string', 'max:100'],
            'CRVERGNO' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'CRKOD.required' => 'Cari kodu zorunludur.',
            'CRKOD.max' => 'Cari kodu en fazla 50 karakter olabilir.',
            'CRISIM.required' => 'Cari ismi zorunludur.',
            'CRISIM.max' => 'Cari ismi en fazla 255 karakter olabilir.',
            'CREMAIL.email' => 'Geçerli bir email adresi giriniz.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'CRKOD' => 'Cari Kodu',
            'CRISIM' => 'Cari İsim',
            'CRADRES' => 'Adres',
            'CRSEHIR' => 'Şehir',
            'CRTEL' => 'Telefon',
            'CRTEL2' => 'Telefon 2',
            'CRGSM' => 'GSM',
            'CREMAIL' => 'Email',
            'CRYETKILI' => 'Yetkili',
            'CRROTA' => 'Rota',
            'CRVERGD' => 'Vergi Dairesi',
            'CRVERGNO' => 'Vergi No',
        ];
    }
}
