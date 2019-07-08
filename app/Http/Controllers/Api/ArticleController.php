<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    /**
     * get top article
     *
     * @return Illuminate\Http\Response
     */
    public function getTopArticle()
    {
        $articles = Article::orderBy('statistic', 'desc')
            ->limit(4)
            ->get($this->getArticleArray());

        if ($articles) {
            return response()->json([
                'result_code' => 4,
                'request_code' => 200,
                'article_list' => $articles
            ]);
        } else {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
    }

    /**
     * get all article
     *
     * @return Illuminate\Http\Response
     */
    public function getArticle(Request $request)
    {
        // initialize variables
        $dataPerPage = $offset = 0;
        $page = 1;

        if ($request->has('count_per_page') && $request->count_per_page != '' && is_numeric($request->count_per_page)) {
            $dataPerPage = $request->count_per_page;
        } else {
            $dataPerPage = 5;
        }

        if ($request->has('page') && $request->page != '' && is_numeric($request->page)) {
            $page = $request->page;
            $offset = ($page - 1) * $dataPerPage;
        } else {
            $offset = ($page - 1) * $dataPerPage;
        }

        $articles = Article::orderBy('created_at', 'asc')->limit($dataPerPage)->offset($offset)->get($this->getArticleArray());

        if ($articles) {
            return response()->json([
                'result_code' => 4,
                'request_code' => 200,
                'article_list' => $articles
            ]);
        } else {
            return response()->json([
                'result_code' => 9,
                'request_code' => 200,
                'message' => 'There is no data'
            ]);
        }
    }

    /**
     * get specific article and deails
     *
     * @return Illuminate\Http\Response
     */
    public function incrementArticleStatistic(Request $request)
    {
        $message = '';
        $result = 0;

        if ($request->has('article_id')) {
            $article = Article::find($request->get('article_id'));
        } else {
            $message = 'Article not found';
        }

        if (isset($article)) {
            $article->increment('statistic', 1);

            $message = 'Add article view by 1';
            $result = 4;
        } else {
            $message = 'There is no data';
            $result = 9;
        }

        return response()->json([
            'result_code' => $result,
            'request_code' => 200,
            'message' => $message
        ]);
    }

    /**
     * get article array
     *
     * @return (array)
     */
    private function getArticleArray(): array
    {
        return [
            'id AS article_id',
            'title AS article_title',
            'author AS article_author',
            'img AS article_image',
            'description AS article_content',
            'statistic AS article_views',
            'created_at AS article_time',
        ];
    }
}
