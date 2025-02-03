<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
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
        }
        $post->images = json_encode([$newimage]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
