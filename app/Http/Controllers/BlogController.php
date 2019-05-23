<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index')
            ->with([
                'articles' => Article::orderBy('statistic', 'desc')->paginate(5)
            ]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', '=', $slug)->first();

        if ($article) {
            $relatedArticles = Article::where('statistic', '<=', $article->statistic)->limit(6)->get();

            return view('blog.show')
                ->with([
                    'article' => $article,
                    'relatedArticles' => $relatedArticles
                ]);
        } else {
            return redirect()->route('blog.index');
        }
    }
}
