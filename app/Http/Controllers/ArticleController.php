<?php

namespace App\Http\Controllers;

use App\Article;
use App\Services\Interfaces\ArticleServiceInterface;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    const validationParams = [
        'title' => 'required|max:150',
        'body' => 'required',
    ];

    /** @var ArticleServiceInterface */
    private $articleService;

    public function __construct(ArticleServiceInterface $articleService) {
        $this->articleService = $articleService;
    }

    public function index()
    {
        return Article::all();
    }

    public function show($id)
    {
        return Article::find($id);
    }

    public function showArticlesByTag($tagId) {
        $tag = Tag::find($tagId);

        if(!empty($tag))
            return Tag::find($tagId)->Articles()->get();

        return response()->json([
            "message" => "There is no tag with that id."
        ], 201);
    }

    public function createArticle(Request $request)
    {
        $image_path = $this->getImagePath($request);

        $validator = $this->creatValidation($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error'], 200);
        }

        $this->articleService->saveArticle($request->title, $request->body, $image_path, $request->tag_ids);

        return response()->json([
            "message" => "article record created"
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validator = $this->creatValidation($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error'], 200);
        }

        $this->articleService->updateArtcile($article, $request);

        return response()->json([
            "message" => "article has been updated"
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $this->articleService->deleteArtcile($article, $request);

        return 204;
    }

    private function getImagePath($request) {
        if(!$request->hasFile('image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $file = $request->file('image');
        if(!$file->isValid()) {
            return response()->json(['invalid_file_upload'], 400);
        }
        $path = public_path() . '\uploads\images\\';
        $file->move($path, $file->getClientOriginalName());

        return $path;
    }

    private function creatValidation($request) {
        return Validator::make($request->all(), self::validationParams);
    }
}
