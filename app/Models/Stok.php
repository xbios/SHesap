<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

/**
 * Stok Model
 *
 * Stok tablosu
 *
 * @property int $SSTOKID Primary key
 * @property int|null $SFIRMAID Firma ID
 * @property string $STOKKOD Stok kodu
 * @property string $STOKADI Stok adı
 * @property string|null $ETICARETKOD E-ticaret kodu
 * @property string|null $STOKADI_PRKND Perakende stok adı
 * @property string|null $STOKGRP1 Stok grubu 1
 * @property string|null $STOKGRP2 Stok grubu 2
 * @property float $STKDV KDV
 * @property float $STKDV2 KDV 2
 * @property float $STALISFIYAT Alış fiyatı
 * @property float $STSATISFIYAT1 Satış fiyatı 1
 * @property float $STSATISFIYAT2 Satış fiyatı 2
 * @property float $STKRITIK Kritik stok seviyesi
 * @property string|null $STBIRIM Birim
 * @property string|null $STBIRIM2 Birim 2
 * @property float $STBIRIM2KATSAYI Birim 2 katsayısı
 * @property float $STISKONTO İskonto oranı
 */
class Stok extends Model
{
    use Loggable;

    /**
     * Veritabanı connection adı
     */
    protected $connection = 'mysql';

    /**
     * Tablo adı
     */
    protected $table = 'stok';

    /**
     * Primary key kolonu
     */
    protected $primaryKey = 'SSTOKID';

    /**
     * Primary key tipi
     */
    protected $keyType = 'int';

    /**
     * Auto-increment durumu
     */
    public $incrementing = true;

    /**
     * Timestamps kullanımı (Tablo yapısına göre false)
     */
    public $timestamps = false;

    /**
     * Mass assignment için izin verilen kolonlar
     */
    protected $fillable = [
        'SFIRMAID',
        'STOKKOD',
        'STOKADI',
        'ETICARETKOD',
        'STOKADI_PRKND',
        'STOKGRP1',
        'STOKGRP2',
        'STKDV',
        'STKDV2',
        'STALISFIYAT',
        'STSATISFIYAT1',
        'STSATISFIYAT2',
        'STKRITIK',
        'STBIRIM',
        'STBIRIM2',
        'STBIRIM2KATSAYI',
        'STISKONTO',
    ];

    /**
     * Kolon tip dönüşümleri
     */
    protected function casts(): array
    {
        return [
            'SFIRMAID' => 'integer',
            'STKDV' => 'float',
            'STKDV2' => 'float',
            'STALISFIYAT' => 'float',
            'STSATISFIYAT1' => 'float',
            'STSATISFIYAT2' => 'float',
            'STKRITIK' => 'float',
            'STBIRIM2KATSAYI' => 'float',
            'STISKONTO' => 'float',
        ];
    }

    /**
     * Firma bazlı filtreleme scope'u
     */
    public function scopeByFirma($query, int $firmaId)
    {
        return $query->where('SFIRMAID', $firmaId);
    }

    /**
     * Arama scope'u
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('STOKKOD', 'like', "%{$term}%")
              ->orWhere('STOKADI', 'like', "%{$term}%")
              ->orWhere('ETICARETKOD', 'like', "%{$term}%");
        });
    }
}
