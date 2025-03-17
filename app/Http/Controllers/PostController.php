<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get(); // Corrigido para plural
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');    
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        Post::create($request->all());
        return redirect()->route('posts.index');
    }

    public function show(string $id)
    {
        $post = Post::findOrFail($id); // Adicionado busca do post
        return view('posts.show', compact('post'));
    }

    // ... (métodos edit, update e destroy permanecem iguais)
}