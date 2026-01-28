<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

/**
 * ApiResponse
 *
 * Standart API response formatı için helper sınıfı.
 *
 * Kullanım:
 * return ApiResponse::success($data, 'İşlem başarılı');
 * return ApiResponse::error('Hata mesajı', 422);
 */
class ApiResponse
{
    /**
     * Başarılı response
     *
     * @param mixed $data Response verisi
     * @param string $message Başarı mesajı
     * @param int $statusCode HTTP status kodu
     */
    public static function success(mixed $data = null, string $message = 'İşlem başarılı', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Oluşturma başarılı response
     */
    public static function created(mixed $data = null, string $message = 'Kayıt oluşturuldu'): JsonResponse
    {
        return static::success($data, $message, 201);
    }

    /**
     * İçeriksiz başarılı response
     */
    public static function noContent(string $message = 'İşlem başarılı'): JsonResponse
    {
        return static::success(null, $message, 204);
    }

    /**
     * Hata response
     *
     * @param string $message Hata mesajı
     * @param int $statusCode HTTP status kodu
     * @param mixed $errors Detaylı hatalar (validation gibi)
     */
    public static function error(string $message = 'Bir hata oluştu', int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Validation hatası response
     */
    public static function validationError(array $errors, string $message = 'Doğrulama hatası'): JsonResponse
    {
        return static::error($message, 422, $errors);
    }

    /**
     * Yetkisizlik response (401)
     */
    public static function unauthorized(string $message = 'Oturum açmanız gerekiyor'): JsonResponse
    {
        return static::error($message, 401);
    }

    /**
     * Yasak response (403)
     */
    public static function forbidden(string $message = 'Bu işlem için yetkiniz bulunmuyor'): JsonResponse
    {
        return static::error($message, 403);
    }

    /**
     * Bulunamadı response (404)
     */
    public static function notFound(string $message = 'Kayıt bulunamadı'): JsonResponse
    {
        return static::error($message, 404);
    }

    /**
     * Sunucu hatası response (500)
     */
    public static function serverError(string $message = 'Sunucu hatası oluştu'): JsonResponse
    {
        return static::error($message, 500);
    }

    /**
     * Sayfalı veri response
     *
     * @param \Illuminate\Pagination\LengthAwarePaginator $paginator
     */
    public static function paginated($paginator, string $message = 'Veriler listelendi'): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $paginator->items(),
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ]);
    }
}
