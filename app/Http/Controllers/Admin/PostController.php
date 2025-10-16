<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(8);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data['user_id'] = Auth::user()->id;

        $post = Post::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El Post se ha creado correctamente.'
        ]);

        return redirect()->route('admin.posts.edit', compact('post'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable',
            'content' => 'nullable',
            'image' => 'nullable|image',
            'is_published' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::delete($post->image_path);
            }
            
            $data['image_path'] = Storage::put('posts', $request->image);
        }

        $post->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El Post se ha actualizado correctamente.'
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
