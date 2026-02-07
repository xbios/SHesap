<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\DB;

class SettingService extends BaseService
{
    public function __construct(SettingRepository $repository)
    {
        parent::__construct($repository);
    }

    public function updateSettings(array $settings)
    {
        return DB::transaction(function () use ($settings) {
            foreach ($settings as $key => $value) {
                DB::table('settings')->where('key', $key)->update([
                    'value' => is_array($value) ? json_encode($value) : $value,
                    'updated_at' => now()
                ]);
            }
            return true;
        });
    }
}
