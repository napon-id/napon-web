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

    public function makeSlug()
    {
        return str_slug($this->title . '-' . str_random(8));
    }
}
