<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Models\Article;
use App\Models\ProgrammingCategory;
use App\Traits\PhotoUploadTrait;
use App\Traits\GlobalDestroyTrait;

class ArticleController extends Controller
{
    use PhotoUploadTrait, GlobalDestroyTrait;

    protected $modelClass = Article::class;

    public function index()
    {
        $this->authorize('viewAny', Article::class);
        $isAdmin = in_array(getActiveUser()->role, ['admin', 'superadmin']);

        $articles = Article::select(['id', 'category_id', 'created_by', 'status', 'created_at', 'updated_at', 'deleted_at'])->with(['category', 'creator']);
        if (!$isAdmin) {
            $articles = $articles->published();
        }

        $articles = $articles->latest()->paginate(15);

        // Calculate statistics
        if ($isAdmin) {
            $allItems = Article::count() ?? 0;
            $published = Article::where('status', 'published')->count() ?? 0;
            $draft = Article::where('status', 'draft')->count() ?? 0;
            $archived = Article::where('status', 'archived')->count() ?? 0;
        } else {
            $allItems = Article::published()->count() ?? 0;
            $published = Article::published()->count() ?? 0;
            $draft = 0;
            $archived = 0;
        }

        return view('dashboard.articles.index', compact('articles', 'allItems', 'published', 'draft', 'archived'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        $categories = ProgrammingCategory::active()->get();
        // dd($categories->toArray());
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
        $categories = ProgrammingCategory::active()->get();
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

        if ($request->hasFile('thumbnail')) {
            $this->uploadSinglePhoto($request, $article, 'thumbnail', 'articles/thumbnails');
        }

        return $updated
            ? redirect()->route('dashboard.articles.index')->withSuccess(__('messages.type_updated', ['type' => __('main.article')]))
            : redirect()->back()->withError(__('messages.type_update_failed', ['type' => __('main.article')]));
    }

    public function destroy(Article $article)
    {
        return $this->destroyModel($article, 'articles');
    }
}
