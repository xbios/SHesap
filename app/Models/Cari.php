<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

/**
 * Cari Model
 *
 * Cari hesaplar tablosu
 *
 * @property int $CRID Primary key
 * @property int $SFIRMAID Firma ID
 * @property string $CRKOD Cari kodu
 * @property string $CRISIM Cari isim
 * @property string|null $CRADRES Adres
 * @property string|null $CRSEHIR Şehir
 * @property string|null $CRTEL Telefon
 * @property string|null $CRTEL2 Telefon 2
 * @property string|null $CRGSM GSM
 * @property string|null $CREMAIL Email
 * @property string|null $WEBSIFRE Web şifre
 * @property string|null $CRYETKILI Yetkili
 * @property string|null $CRROTA Rota
 * @property string|null $CRVERGD Vergi dairesi
 * @property string|null $CRVERGNO Vergi numarası
 */
class Cari extends Model
{
    use Loggable;

    /**
     * Veritabanı connection adı
     */
    protected $connection = 'mysql';

    /**
     * Tablo adı
     */
    protected $table = 'cari';

    /**
     * Primary key kolonu
     */
    protected $primaryKey = 'CRID';

    /**
     * Primary key tipi
     */
    protected $keyType = 'int';

    /**
     * Auto-increment durumu
     */
    public $incrementing = true;

    /**
     * Timestamps kullanımı
     */
    public $timestamps = false;

    /**
     * Mass assignment için izin verilen kolonlar
     *
     * @var list<string>
     */
    protected $fillable = [
        'SFIRMAID',
        'CRKOD',
        'CRISIM',
        'CRADRES',
        'CRSEHIR',
        'CRTEL',
        'CRTEL2',
        'CRGSM',
        'CREMAIL',
        'WEBSIFRE',
        'CRYETKILI',
        'CRROTA',
        'CRVERGD',
        'CRVERGNO',
    ];

    /**
     * Kolon tip dönüşümleri
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'SFIRMAID' => 'integer',
        ];
    }

    /**
     * Log'dan hariç tutulacak alanlar
     *
     * @return array<string>
     */
    public function getLogExceptAttributes(): array
    {
        return ['WEBSIFRE'];
    }

    /**
     * Aktif cari hesapları filtrele
     */
    public function scopeByFirma(\Illuminate\Database\Eloquent\Builder $query, int $firmaId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('SFIRMAID', $firmaId);
    }

    /**
     * Arama scope'u
     */
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, string $term): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where(function ($q) use ($term) {
            $q->where('CRKOD', 'like', "%{$term}%")
              ->orWhere('CRISIM', 'like', "%{$term}%")
              ->orWhere('CRTEL', 'like', "%{$term}%")
              ->orWhere('CREMAIL', 'like', "%{$term}%");
        });
    }
}
