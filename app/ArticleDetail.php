<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Article;

class ArticleDetail extends Model
{
    protected $fillable = [
        'article_id',
        'img',
        'description'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
