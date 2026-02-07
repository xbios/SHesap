<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StokStoreRequest;
use App\Http\Requests\StokUpdateRequest;
use App\Services\StokService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * StokController
 *
 * Stoklar CRUD controller
 */
class StokController extends Controller
{
    /**
     * Service instance
     */
    protected StokService $service;

    /**
     * Constructor
     */
    public function __construct(StokService $service)
    {
        $this->service = $service;
    }

    /**
     * Listeleme sayfası
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'grup1', 'grup2', 'sort_by', 'sort_order']);
        $perPage = $request->integer('per_page', 15);

        $stoklar = $this->service->search($filters, $perPage);
        $grup1List = $this->service->getGruplar('STOKGRP1');
        $grup2List = $this->service->getGruplar('STOKGRP2');

        return view('stok.index', [
            'stoklar' => $stoklar,
            'grup1List' => $grup1List,
            'grup2List' => $grup2List,
            'filters' => $filters,
        ]);
    }

    /**
     * Detay sayfası
     */
    public function show(int $id): View
    {
        $stok = $this->service->findOrFail($id);

        return view('stok.show', [
            'stok' => $stok,
        ]);
    }

    /**
     * Oluşturma formu
     */
    public function create(): View
    {
        return view('stok.create');
    }

    /**
     * Yeni kayıt oluştur
     */
    public function store(StokStoreRequest $request): RedirectResponse
    {
        try {
            $stok = $this->service->createStok($request->validated());

            return redirect()
                ->route('stok.show', $stok->SSTOKID)
                ->with('success', 'Stok kartı başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Stok kartı oluşturulurken hata: ' . $e->getMessage());
        }
    }

    /**
     * Düzenleme formu
     */
    public function edit(int $id): View
    {
        $stok = $this->service->findOrFail($id);

        return view('stok.edit', [
            'stok' => $stok,
        ]);
    }

    /**
     * Kayıt güncelle
     */
    public function update(StokUpdateRequest $request, int $id): RedirectResponse
    {
        try {
            $this->service->updateStok($id, $request->validated());

            return redirect()
                ->route('stok.show', $id)
                ->with('success', 'Stok kartı başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Stok kartı güncellenirken hata: ' . $e->getMessage());
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
                ->route('stok.index')
                ->with('success', 'Stok kartı başarıyla silindi.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Stok kartı silinirken hata: ' . $e->getMessage());
        }
    }
}
