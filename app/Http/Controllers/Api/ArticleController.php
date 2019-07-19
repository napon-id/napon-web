<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Http\Controllers\Traits\APIHelper;

class ArticleController extends Controller
{
    use APIHelper;

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

        if ($articles->count() > 0) {
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
        $pagination = $this->paginateResult($request);

        $articles = Article::orderBy('created_at', 'asc')
            ->limit($pagination['dataPerPage'])
            ->offset($pagination['offset'])
            ->get($this->getArticleArray());

        if ($articles->count() > 0) {
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
     * increment article views by 1
     *
     * @return Illuminate\Http\Response
     */
    public function incrementArticleStatistic(Request $request)
    {
        if ($request->has('article_id') && $request->article_id != '') {
            $article = Article::find($request->get('article_id'));
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 9,
                'message' => 'There is no data'
            ]);
        }

        if (isset($article)) {
            $article->increment('statistic', 1);
            return response()->json([
                'request_code' => 200,
                'result_code' => 4,
                'message' => 'Add article view by 1'
            ]);
        } else {
            return response()->json([
                'request_code' => 200,
                'result_code' => 9,
                'message' => 'There is no data'
            ]);
        }
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
