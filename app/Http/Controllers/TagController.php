<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\TagServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    const validationParams =  [
        'name' => 'required|max:255'
    ];

    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService) {
        $this->tagService = $tagService;
    }

    public function createTag(Request $request) {
        $validator = $this->creatValidation($request);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error'], 200);
        }

        $this->tagService->saveTag($request->name);

        return response()->json([
            "message" => "Tag has been created."
        ], 201);
    }

    private function creatValidation($request) {
        return Validator::make($request->all(), self::validationParams);
    }
}
