<?php

declare(strict_types=1);

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use App\Http\Requests\Examples\ExampleStoreRequest;
use App\Http\Requests\Examples\ExampleUpdateRequest;
use App\Services\Examples\ExampleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * ExampleController
 *
 * Controller şablonu - yeni controller oluştururken bu dosyayı referans alın.
 *
 * KULLANIM:
 * 1. Bu dosyayı kopyalayın
 * 2. Namespace ve class adını değiştirin
 * 3. Service'i inject edin
 * 4. View ve route isimlerini güncelleyin
 */
class ExampleController extends Controller
{
    /**
     * Service instance
     */
    protected ExampleService $service;

    /**
     * Constructor - Service injection
     */
    public function __construct(ExampleService $service)
    {
        $this->service = $service;

        // Middleware tanımları (opsiyonel)
        // $this->middleware('permission:examples.view')->only(['index', 'show']);
        // $this->middleware('permission:examples.create')->only(['create', 'store']);
        // $this->middleware('permission:examples.edit')->only(['edit', 'update']);
        // $this->middleware('permission:examples.delete')->only('destroy');
    }

    /**
     * Listeleme sayfası
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'is_active', 'sort_by', 'sort_order']);
        $perPage = $request->integer('per_page', 15);

        $items = $this->service->search($filters, $perPage);
        $statistics = $this->service->getStatistics();

        return view('examples.index', [
            'items' => $items,
            'statistics' => $statistics,
            'filters' => $filters,
        ]);
    }

    /**
     * Detay sayfası
     */
    public function show(int $id): View
    {
        $item = $this->service->findOrFail($id);

        return view('examples.show', [
            'item' => $item,
        ]);
    }

    /**
     * Oluşturma formu
     */
    public function create(): View
    {
        return view('examples.create');
    }

    /**
     * Yeni kayıt oluştur
     */
    public function store(ExampleStoreRequest $request): RedirectResponse
    {
        try {
            $item = $this->service->createWithRules($request->validated());

            return redirect()
                ->route('examples.show', $item->id)
                ->with('success', 'Kayıt başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Kayıt oluşturulurken hata: ' . $e->getMessage());
        }
    }

    /**
     * Düzenleme formu
     */
    public function edit(int $id): View
    {
        $item = $this->service->findOrFail($id);

        return view('examples.edit', [
            'item' => $item,
        ]);
    }

    /**
     * Kayıt güncelle
     */
    public function update(ExampleUpdateRequest $request, int $id): RedirectResponse
    {
        try {
            $this->service->updateWithRules($id, $request->validated());

            return redirect()
                ->route('examples.show', $id)
                ->with('success', 'Kayıt başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Kayıt güncellenirken hata: ' . $e->getMessage());
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
                ->route('examples.index')
                ->with('success', 'Kayıt başarıyla silindi.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Kayıt silinirken hata: ' . $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EKSTRA AKSIYONLAR
    |--------------------------------------------------------------------------
    */

    /**
     * Toplu aktif et
     */
    public function bulkActivate(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:examples,id',
        ]);

        $count = $this->service->bulkActivate($request->input('ids'));

        return back()->with('success', "{$count} kayıt aktif edildi.");
    }

    /**
     * Toplu deaktif et
     */
    public function bulkDeactivate(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:examples,id',
        ]);

        $count = $this->service->bulkDeactivate($request->input('ids'));

        return back()->with('success', "{$count} kayıt deaktif edildi.");
    }
}
