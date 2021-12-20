<?php

namespace App\Services;

use App\Article;
use App\Services\Interfaces\ArticleServiceInterface;
use App\Tag;

class ArticleService implements ArticleServiceInterface
{
    public function __construct()
    {
    }

    public function saveArticle($title, $body, $image_path, $tagIds) {
        $article = new Article();

        $article->title = $title;
        $article->body = $body;
        $article->image_path = $image_path;
        $article->save();

        $tags = Tag::find($tagIds);
        $article->tags()->attach($tags);
    }

    public function updateArtcile($article, $request) {
        $article->update($request->all());

        $tags = Tag::find($request->tag_ids);
        $article->tags()->sync($tags);
    }

    public function deleteArticle($article, $request)  {
        $article->delete();

        $tags = Tag::find($request->tag_ids);
        $article->tags()->detach($tags);
    }
}
