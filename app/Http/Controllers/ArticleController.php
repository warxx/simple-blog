<?php

namespace App\Http\Controllers;

use App\Article;
use App\Services\Interfaces\ArticleServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /** @var ArticleServiceInterface */
    private $articleService;

    public function __construct(ArticleServiceInterface $articleService) {
        $this->articleService = $articleService;
    }

    public function index()
    {
        return response()->json([
            "message" => "all articles"
        ], 201);
    }

    public function show($id)
    {
        return Article::find($id);
    }

    public function createArticle(Request $request)
    {
        $image_path = $this->getImagePath($request);

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:150',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error'], 200);
        }

        $this->articleService->saveArticle($request->title, $request->body, $image_path,  $request->tag_ids);

        return response()->json([
            "message" => "article record created"
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

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
}
