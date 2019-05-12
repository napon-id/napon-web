<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ArticleDetail;

class Article extends Model
{
    protected $fillable = [
        'title',
        'img',
        'description',
        'statistic',
        'author'
    ];

    public function articleDetails()
    {
        return $this->hasMany(ArticleDetail::class);
    }
}
