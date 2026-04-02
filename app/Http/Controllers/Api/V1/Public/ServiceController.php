<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    use ApiResponseTrait;

    public function index(): JsonResponse
    {
        $services = Service::active()->published()->orderBy('order')->get();

        return $this->successResponse(ServiceResource::collection($services));
    }
}
