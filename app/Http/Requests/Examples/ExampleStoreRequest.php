<?php

declare(strict_types=1);

namespace App\Http\Requests\Examples;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * ExampleStoreRequest
 *
 * FormRequest şablonu - yeni request oluştururken bu dosyayı referans alın.
 *
 * KULLANIM:
 * 1. Bu dosyayı kopyalayın
 * 2. Namespace ve class adını değiştirin
 * 3. rules() metodunda validation kurallarını tanımlayın
 * 4. messages() ve attributes() metodlarını özelleştirin
 */
class ExampleStoreRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapma yetkisi var mı?
     */
    public function authorize(): bool
    {
        // Yetki kontrolü (true = yetkili, false = yetkisiz)
        // return $this->user()->hasPermission('examples.create');
        return true;
    }

    /**
     * Validation kuralları
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
            'metadata' => [
                'nullable',
                'array',
            ],
            'metadata.key' => [
                'nullable',
                'string',
                'max:100',
            ],
        ];
    }

    /**
     * Özel hata mesajları
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'İsim alanı zorunludur.',
            'name.min' => 'İsim en az :min karakter olmalıdır.',
            'name.max' => 'İsim en fazla :max karakter olabilir.',
            'user_id.required' => 'Kullanıcı seçimi zorunludur.',
            'user_id.exists' => 'Seçilen kullanıcı bulunamadı.',
        ];
    }

    /**
     * Özel alan isimleri
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'isim',
            'user_id' => 'kullanıcı',
            'is_active' => 'aktiflik durumu',
            'metadata' => 'meta veriler',
        ];
    }

    /**
     * Validasyon öncesi veri hazırlama
     */
    protected function prepareForValidation(): void
    {
        // Veriyi temizle veya dönüştür
        $this->merge([
            'name' => trim($this->input('name', '')),
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * Doğrulanmış veriyi al (özelleştirilmiş)
     *
     * @return array<string, mixed>
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated();

        // Ek dönüşümler
        if (isset($validated['is_active'])) {
            $validated['is_active'] = (bool) $validated['is_active'];
        }

        return $validated;
    }
}
