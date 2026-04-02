<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 15), 50);
        $projects = Project::active()->orderBy('order')->paginate($perPage);

        return $this->paginatedResponse($projects, fn($p) => new ProjectResource($p));
    }

    public function show(int $id): JsonResponse
    {
        $project = Project::active()->find($id);

        if (! $project) {
            return $this->notFoundResponse('Project not found.');
        }

        return $this->successResponse(new ProjectResource($project));
    }
}
