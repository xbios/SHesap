<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * BaseApiController
 *
 * API controller'lar için temel sınıf.
 * Standart response formatı ve yardımcı metodlar sağlar.
 */
class BaseApiController extends Controller
{
    /**
     * Başarılı response döndür
     */
    protected function success(mixed $data = null, string $message = 'İşlem başarılı', int $statusCode = 200): JsonResponse
    {
        return ApiResponse::success($data, $message, $statusCode);
    }

    /**
     * Oluşturma başarılı response
     */
    protected function created(mixed $data = null, string $message = 'Kayıt oluşturuldu'): JsonResponse
    {
        return ApiResponse::created($data, $message);
    }

    /**
     * Hata response
     */
    protected function error(string $message = 'Bir hata oluştu', int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        return ApiResponse::error($message, $statusCode, $errors);
    }

    /**
     * Validation hatası
     */
    protected function validationError(array $errors, string $message = 'Doğrulama hatası'): JsonResponse
    {
        return ApiResponse::validationError($errors, $message);
    }

    /**
     * Bulunamadı response
     */
    protected function notFound(string $message = 'Kayıt bulunamadı'): JsonResponse
    {
        return ApiResponse::notFound($message);
    }

    /**
     * Yetkisiz response
     */
    protected function unauthorized(string $message = 'Oturum açmanız gerekiyor'): JsonResponse
    {
        return ApiResponse::unauthorized($message);
    }

    /**
     * Yasak response
     */
    protected function forbidden(string $message = 'Bu işlem için yetkiniz bulunmuyor'): JsonResponse
    {
        return ApiResponse::forbidden($message);
    }

    /**
     * Sayfalı response
     */
    protected function paginated($paginator, string $message = 'Veriler listelendi'): JsonResponse
    {
        return ApiResponse::paginated($paginator, $message);
    }
}
