<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailPostResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
       // return response()->json(['data' => $post]);
       return PostResource::collection($posts);
    }

    public function show($id) {
        $post = Post::with('writer:id,username')->findOrFail($id);
        return new DetailPostResource($post);
    }
}
