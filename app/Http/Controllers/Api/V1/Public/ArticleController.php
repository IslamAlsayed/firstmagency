<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $query = Article::published();

        if ($request->filled('category_id')) {
            $query->byCategory($request->integer('category_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(translations, '$.ar.title')) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(translations, '$.en.title')) LIKE ?", ["%{$search}%"]);
            });
        }

        $perPage = min($request->integer('per_page', 15), 50);
        $articles = $query->orderBy('published_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse($articles, fn($a) => new ArticleResource($a));
    }

    public function show(int $id): JsonResponse
    {
        $article = Article::published()->with('category')->find($id);

        if (! $article) {
            return $this->notFoundResponse('Article not found.');
        }

        return $this->successResponse(new ArticleResource($article));
    }
}
