<?php

namespace app\Services\Interfaces;

interface ArticleServiceInterface {
    public function saveArticle($title, $body, $image_path, $tagIds);

    public function updateArtcile($article, $request);

    public function deleteArticle($article, $request);
}
