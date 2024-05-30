<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    protected const SERVICE_CLASS = ServiceInterface::class;
    private const ERROR_CHANNEL = 'error';

    /**
     * Handle the incoming request.
     *
     * @param  Request  $request  The incoming request.
     * @return JsonResponse|JsonResource The JSON response or resource.
     *
     * @throws \Throwable
     */
    public function handle(Request $request): JsonResponse|JsonResource
    {
        try {
            $service = App::make(static::SERVICE_CLASS);

            $request->validated();

            $response = $service->__invoke($request);
        } catch (\Throwable $e) {
            $exceptionCode = $e->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;

            $code = (is_int($exceptionCode) && $exceptionCode >= 100 && $exceptionCode <= 599)
                ? $exceptionCode
                : 500;

            Log::channel(self::ERROR_CHANNEL)->error('An Error Occurred', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'status' => Response::$statusTexts[$code]
            ], $code);
        }

        return $response;
    }
}
