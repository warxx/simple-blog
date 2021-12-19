<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function createTag(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'error'], 200);
        }

        $tag = new Tag();

        $tag->name = $request->name;
        $tag->save();

        return response()->json([
            "message" => "Tag has been created."
        ], 201);
    }
}
