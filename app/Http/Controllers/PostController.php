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
    public function createPost(Request $request)
    {
        
        // dd($request->file('images'));
        // if ($request->hasFile('images')) {
        //     $newimage = $request->file('images')->store('images','public');
        // }

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        if ($request->hasFile('images')) {
            $newimage = $request->file('images')->store('images','public');
            $imagedata = Storage::disk('public')->get($newimage);
            $base64 = base64_encode($imagedata);
        }
        $post->images = $base64;
        $post->save();
        return  response()->json([
            'message' => 'success',
            'title' => $post->title,
            'desc' => $post->description,
            'dbimg' => $post->images,
            'reqimg' => $request->images
        ]);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePost(Request $request, string $id)
    {
        $post = Post::find($id);
    
        $post->title = $request->title;
        $post->description = $request->description;
    
        $existingImages = $post->images ? json_decode($post->images, true) : [];
    
        if ($request->hasFile('images')) {
            foreach ($existingImages as $oldImage) {
                Storage::delete('public/' . $oldImage);
            }
    
            $newImages = [];
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images', 'public'); 
                $newImages[] = $imagePath; 
            }
    
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

    
    



