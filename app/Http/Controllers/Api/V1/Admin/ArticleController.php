<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use App\Traits\ApiResponseTrait;
use App\Traits\PhotoUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use ApiResponseTrait, PhotoUploadTrait;

    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->integer('per_page', 20), 100);
        $articles = Article::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return $this->paginatedResponse($articles, fn($a) => new ArticleResource($a));
    }

    public function show(int $id): JsonResponse
    {
        $article = Article::with('category')->find($id);

        return $article
            ? $this->successResponse(new ArticleResource($article))
            : $this->notFoundResponse('Article not found.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'translations'   => ['required', 'array'],
            'translations.ar' => ['required', 'array'],
            'translations.ar.title' => ['required', 'string', 'max:255'],
            'category_id'    => ['nullable', 'exists:programming_categories,id'],
            'status'         => ['nullable', 'string'],
            'is_active'      => ['nullable', 'boolean'],
            'published_at'   => ['nullable', 'date'],
            'thumbnail'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:3072'],
        ]);

        $article = Article::create([
            ...$validated,
            'created_by' => $request->user()->id,
        ]);

        if ($request->hasFile('thumbnail')) {
            $this->uploadSinglePhoto($request, $article, 'thumbnail', 'articles', 'thumbnail');
        }

        return $this->successResponse(new ArticleResource($article), 'Article created.', 201);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $article = Article::find($id);

        if (! $article) {
            return $this->notFoundResponse('Article not found.');
        }

        $validated = $request->validate([
            'translations'   => ['sometimes', 'required', 'array'],
            'category_id'    => ['nullable', 'exists:programming_categories,id'],
            'status'         => ['nullable', 'string'],
            'is_active'      => ['nullable', 'boolean'],
            'published_at'   => ['nullable', 'date'],
            'thumbnail'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:3072'],
        ]);

        $article->update([
            ...$validated,
            'updated_by' => $request->user()->id,
        ]);

        if ($request->hasFile('thumbnail')) {
            $this->uploadSinglePhoto($request, $article, 'thumbnail', 'articles', 'thumbnail');
        }

        return $this->successResponse(new ArticleResource($article), 'Article updated.');
    }

    public function destroy(int $id): JsonResponse
    {
        $article = Article::find($id);

        if (! $article) {
            return $this->notFoundResponse('Article not found.');
        }

        $article->delete();

        return $this->successResponse(null, 'Article deleted.');
    }
}
