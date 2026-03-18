<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ProgrammingCategory;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Cache::remember('home_articles', 1800, function () {
            return Article::active()->published()->get();
        });
        return view('website.blog', compact('articles'));
    }

    public function category($id)
    {
        $articles = Article::where('category_id', $id)->active()->published()->get();
        return view('website.blog', compact('articles'));
    }

    public function show($id, $slug)
    {
        $article = Article::find($id);
        if (!$article)
            return redirect()->back()->withError(__('messages.type_not_found', ['type' => __('main.article')]));

        // Count each article visit.
        $article->increment('visitors');
        $article->refresh();

        $categories = ProgrammingCategory::withCount('articles')->get();

        $articles = Cache::remember('home_articles', 1800, function () {
            return Article::active()->published()->limit(10)->get();
        });

        $mostReadArticles = Cache::remember('most_read_articles', 1800, function () {
            return Article::active()->published()->orderBy('visitors', 'desc')->limit(7)->get();
        });

        $similarArticles = [];
        if ($article->category_id) {
            $similarArticles = Article::where('id', '!=', $article->id)
                ->where('category_id', $article->category_id)
                ->active()->published()->limit(3)->get();
        }

        return view('website.blogShow', compact('article', 'articles', 'similarArticles', 'categories', 'mostReadArticles'));
    }
}
