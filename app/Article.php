<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ArticleDetail;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'img',
        'description',
        'statistic',
        'author'
    ];

    public function articleDetails()
    {
        return $this->hasMany(ArticleDetail::class);
    }

    public function makeSlug($title)
    {
        return str_slug($title . '-' . str_random(8));
    }
}
