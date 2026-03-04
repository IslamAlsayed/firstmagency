<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class ArticleController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Article::class;

    public function index()
    {
        $this->authorize('viewAny', Article::class);
        $articles = Article::with(['category', 'creator'])->latest()->paginate(15);
        return view('dashboard.articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        $categories = Category::active()->get();
        return view('dashboard.articles.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Article::class);
        $validated = $request->validated();
        $validated['created_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
                'keywords' => $request->input("keywords_{$lang}") ?? '',
                'meta_description' => $request->input("meta_description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $article = Article::create($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $article, 'image', 'articles/images');
        }
        if ($request->hasFile('thumbnail')) {
            $this->uploadSinglePhoto($request, $article, 'thumbnail', 'articles/thumbnails');
        }

        return $article
            ? ($request->has('save_and_add')
                ? redirect()->back()->withSuccess(__('messages.article_created'))
                : redirect()->route('dashboard.articles.index')->withSuccess(__('messages.type_created', ['type' => __('main.article')])))
            : redirect()->route('dashboard.articles.index')->withError(__('messages.type_creation_failed', ['type' => __('main.article')]));
    }

    public function show($id)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('dashboard.articles.index')->withError(__('messages.type_not_found', ['type' => __('main.article')]));
        $this->authorize('view', $article);
        return view('dashboard.articles.show', compact('article'));
    }

    public function edit($id)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('dashboard.articles.index')->withError(__('messages.type_not_found', ['type' => __('main.article')]));
        $this->authorize('update', $article);
        $categories = Category::active()->get();
        return view('dashboard.articles.edit', compact('article', 'categories'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('dashboard.articles.index')->withError(__('messages.type_not_found', ['type' => __('main.article')]));
        $this->authorize('update', $article);

        $validated = $request->validated();
        $validated['updated_by'] = getActiveUserId();

        // Build translations array from form inputs
        $translations = [];

        foreach (array_keys(config('languages')) as $lang) {
            $translations[$lang] = [
                'title' => $request->input("title_{$lang}") ?? '',
                'description' => $request->input("description_{$lang}") ?? '',
                'content' => $request->input("content_{$lang}") ?? '',
                'keywords' => $request->input("keywords_{$lang}") ?? '',
                'meta_description' => $request->input("meta_description_{$lang}") ?? '',
            ];
        }

        $validated['translations'] = $translations;
        $updated = $article->update($validated);

        if ($request->hasFile('image')) {
            $this->uploadSinglePhoto($request, $article, 'image', 'articles/images');
        }
        if ($request->hasFile('thumbnail')) {
            $this->uploadSinglePhoto($request, $article, 'thumbnail', 'articles/thumbnails');
        }

        return $updated
            ? redirect()->back()->withSuccess(__('messages.type_updated', ['type' => __('main.article')]))
            : redirect()->route('dashboard.articles.index')->withError(__('messages.type_update_failed', ['type' => __('main.article')]));
    }

    public function changeStatus($id, $status)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('dashboard.articles.index')->withError(__('messages.type_not_found', ['type' => __('main.article')]));

        // Check if user can update articles
        $this->authorize('update', $article);

        // Validate status
        $validStatuses = ['draft', 'published', 'archived'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('dashboard.articles.index')->withError(__('messages.invalid_status'));
        }

        $article->update([
            'status' => $status,
            'updated_by' => getActiveUserId(),
        ]);

        $statusLabel = __('main.status_' . $status);
        return redirect()->route('dashboard.articles.index')->withSuccess(__('messages.type_updated', ['type' => __('main.article')]) . ' - ' . $statusLabel);
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->route('dashboard.articles.index')->withError(__('messages.type_not_found', ['type' => __('main.article')]));
        $this->authorize('delete', $article);
        $article->delete();
        return redirect()->route('dashboard.articles.index')->withSuccess(__('messages.type_deleted', ['type' => __('main.article')]));
    }
}
