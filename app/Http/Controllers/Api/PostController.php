<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'required|max:255',
            'subheading' => 'max:255',
            'text' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for image file
        ]);

        $post = new Post($request->only('heading', 'subheading', 'text'));
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = 'images/'.$imageName;
        }

        $post->save();

        return response()->json(['success' => 'Post created successfully.']);
    }
}
