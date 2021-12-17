<?php

namespace App\Services;

use App\Article;
use App\Services\Interfaces\ArticleServiceInterface;

class ArticleService implements ArticleServiceInterface
{
    public function saveArticle($title, $body, $image_path) {
        $article = new Article();

        $article->title = $title;
        $article->body = $body;
        $article->image_path = $image_path;
        $article->save();
    }
}
