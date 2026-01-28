<?php

declare(strict_types=1);

namespace App\Http\Requests\Examples;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

/**
 * ExampleUpdateRequest
 *
 * Update için FormRequest şablonu
 */
class ExampleUpdateRequest extends FormRequest
{
    /**
     * Kullanıcının bu isteği yapma yetkisi var mı?
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation kuralları
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Route'dan ID'yi al
        $id = $this->route('example') ?? $this->route('id');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'min:2',
                'max:255',
                // Benzersizlik kontrolü (kendi kaydı hariç)
                // Rule::unique('examples', 'name')->ignore($id),
            ],
            'user_id' => [
                'sometimes',
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
            'name.unique' => 'Bu isim zaten kullanılıyor.',
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
        ];
    }
}
