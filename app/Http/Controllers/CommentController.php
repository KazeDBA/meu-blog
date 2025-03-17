<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => Auth::id() // Remove se não tiver autenticação
        ]);

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Comentário publicado!');
    }

    /**
     * Remove um comentário específico
     */
    public function destroy(Post $post, Comment $comment)
    {
        // Verifica se o usuário tem permissão (opcional)
        if (Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->is_admin)) {
            $comment->delete();
            return redirect()->back()
                ->with('success', 'Comentário excluído!');
        }

        // Se não tiver permissão
        return redirect()->back()
            ->with('error', 'Ação não autorizada!');
    }
}