<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;
    protected $settingRepository;

    public function __construct(SettingService $settingService, SettingRepository $settingRepository)
    {
        $this->settingService = $settingService;
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $settingsGrouped = $this->settingRepository->getAllGrouped();
        return view('admin.settings.index', compact('settingsGrouped'));
    }

    public function update(Request $request)
    {
        $settings = $request->except('_token');
        $this->settingService->updateSettings($settings);

        return redirect()->route('settings.index')->with('success', 'Ayarlar başarıyla güncellendi.');
    }
}
