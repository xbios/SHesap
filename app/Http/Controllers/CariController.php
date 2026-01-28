<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CariStoreRequest;
use App\Http\Requests\CariUpdateRequest;
use App\Services\CariService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CariController
 *
 * Cari hesaplar CRUD controller
 */
class CariController extends Controller
{
    /**
     * Service instance
     */
    protected CariService $service;

    /**
     * Constructor
     */
    public function __construct(CariService $service)
    {
        $this->service = $service;
    }

    /**
     * Listeleme sayfası
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'sehir', 'sort_by', 'sort_order']);
        $perPage = $request->integer('per_page', 15);

        $cariler = $this->service->search($filters, $perPage);
        $sehirler = $this->service->getSehirler();

        return view('cari.index', [
            'cariler' => $cariler,
            'sehirler' => $sehirler,
            'filters' => $filters,
        ]);
    }

    /**
     * Detay sayfası
     */
    public function show(int $id): View
    {
        $cari = $this->service->findOrFail($id);

        return view('cari.show', [
            'cari' => $cari,
        ]);
    }

    /**
     * Oluşturma formu
     */
    public function create(): View
    {
        return view('cari.create');
    }

    /**
     * Yeni kayıt oluştur
     */
    public function store(CariStoreRequest $request): RedirectResponse
    {
        try {
            $cari = $this->service->createCari($request->validated());

            return redirect()
                ->route('cari.show', $cari->CRID)
                ->with('success', 'Cari hesap başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cari hesap oluşturulurken hata: ' . $e->getMessage());
        }
    }

    /**
     * Düzenleme formu
     */
    public function edit(int $id): View
    {
        $cari = $this->service->findOrFail($id);

        return view('cari.edit', [
            'cari' => $cari,
        ]);
    }

    /**
     * Kayıt güncelle
     */
    public function update(CariUpdateRequest $request, int $id): RedirectResponse
    {
        try {
            $this->service->updateCari($id, $request->validated());

            return redirect()
                ->route('cari.show', $id)
                ->with('success', 'Cari hesap başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cari hesap güncellenirken hata: ' . $e->getMessage());
        }
    }

    /**
     * Kayıt sil
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->service->delete($id);

            return redirect()
                ->route('cari.index')
                ->with('success', 'Cari hesap başarıyla silindi.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Cari hesap silinirken hata: ' . $e->getMessage());
        }
    }
}
