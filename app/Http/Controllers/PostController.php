<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DetailPostResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
       // return response()->json(['data' => $post]);
       return PostResource::collection($posts->loadMissing('writer:id,username'));
    }

    public function show($id) {
        $post = Post::with('writer:id,username', 'comments:id,post_id,user_id,comments_content')->findOrFail($id);
        return new DetailPostResource($post);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $image = null;

        if($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName.'.'.$extension;
            Storage::putFileAs('image', $request->file, $image);
        }

        // return response()->json('sudah bisa digunakan');
        $request['image'] = $image;
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        
        return new DetailPostResource($post->loadMissing('writer:id,username'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $image = null;

        if($request->file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName.'.'.$extension;
            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;


        $post = Post::findOrFail($id);
        $post->update($request->all());

        // return response()->json('sudah diubah');
        return new DetailPostResource($post->loadMissing('writer:id,username'));
    }

    public function delete($id) {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'messege' => 'data telah terhapus'
        ]);
    }


    public function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
