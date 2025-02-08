<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'posts' => $posts,
            'message' => 'success'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updatePost(Request $request, string $id)
{
    $post = Post::find($id);

    $post->title = $request->title;
    $post->description = $request->description;

    if ($request->hasFile('images')) {
        $newImages = [];
        foreach ($request->file('images') as $image) {
            // Store image file and get the path
            $imagePath = $image->store('images', 'public');
            // Get image data and encode it as base64
            $imageData = Storage::disk('public')->get($imagePath);
            $base64 = base64_encode($imageData);
            $newImages[] = $base64;
        }

        // Save the base64 encoded images
        $post->images = json_encode($newImages);
    }

    $post->save();

    return response()->json([
        'message' => 'Post updated successfully!',
        'title' => $post->title,
        'description' => $post->description,
        'images' => json_decode($post->images, true)
    ]);
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if ($post) {
            $post -> delete();
        } 

        return response()->json([
            'message' => 'post is deleted'
        ]);
        
        
    }
}

    
    



