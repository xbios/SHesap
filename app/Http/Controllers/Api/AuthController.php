<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Responses\ApiResponse;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController
 *
 * API authentication işlemleri için controller.
 * Login, logout, token yönetimi.
 */
class AuthController extends BaseApiController
{
    protected ActivityLogger $logger;

    public function __construct(ActivityLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Kullanıcı girişi ve token oluşturma
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string|max:255',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Geçersiz email veya şifre.', 401);
        }

        // Token oluştur
        $deviceName = $request->input('device_name', 'api_token');
        $token = $user->createToken($deviceName)->plainTextToken;

        // Login log
        $this->logger->logLogin($user);

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Giriş başarılı.');
    }

    /**
     * Kullanıcı çıkışı ve token silme
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        // Mevcut token'ı sil
        $request->user()->currentAccessToken()->delete();

        // Logout log
        $this->logger->logLogout($user);

        return $this->success(null, 'Çıkış başarılı.');
    }

    /**
     * Tüm token'ları sil (tüm cihazlardan çıkış)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Tüm oturumlar sonlandırıldı.');
    }

    /**
     * Token yenile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();

        // Eski token'ı sil
        $request->user()->currentAccessToken()->delete();

        // Yeni token oluştur
        $deviceName = $request->input('device_name', 'api_token');
        $newToken = $user->createToken($deviceName)->plainTextToken;

        return $this->success([
            'token' => $newToken,
            'token_type' => 'Bearer',
        ], 'Token yenilendi.');
    }

    /**
     * Mevcut kullanıcı bilgisi
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->success([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('slug'),
        ]);
    }
}
