@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container mt-4">
    <!-- Botão Voltar -->
    <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mb-4">
        &larr; Voltar para Posts
    </a>

    <!-- Card do Post -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h1 class="mb-0">{{ $post->title }}</h1>
        </div>
        
        <div class="card-body">
            <p class="lead">{{ $post->content }}</p>
            <div class="text-muted small">
                Criado em: {{ $post->created_at->format('d/m/Y H:i') }}
                @if($post->created_at != $post->updated_at)
                    <br>Última atualização: {{ $post->updated_at->format('d/m/Y H:i') }}
                @endif
            </div>
        </div>
    </div>

    <!-- Seção de Comentários -->
    <div class="mt-5">
        <h3 class="mb-4">
            Comentários
            <span class="badge bg-secondary">{{ $post->comments->count() }}</span>
        </h3>

        <!-- Lista de Comentários -->
        @forelse($post->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="mb-1">{{ $comment->content }}</p>
                            <small class="text-muted">
                                Por: {{ $comment->user->name ?? 'Anônimo' }} • 
                                {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        <!-- Botão Excluir Comentário -->
                        @auth
                            @if(auth()->user()->id === $comment->user_id || auth()->user()->is_admin)
                                <form action="{{ route('comments.destroy', [$post->id, $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Nenhum comentário ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- Formulário de Comentário -->
        @auth
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Deixe seu comentário</h5>
                    
                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea 
                                name="content" 
                                class="form-control" 
                                rows="3" 
                                placeholder="Escreva seu comentário..."
                                required
                            ></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Enviar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="alert alert-warning mt-4">
                <a href="{{ route('login') }}" class="alert-link">Faça login</a> para comentar.
            </div>
        @endauth
    </div>

    <!-- Mensagens de Feedback -->
    @if(session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card-header {
        border-radius: 0.25rem 0.25rem 0 0;
    }
    .text-muted {
        font-size: 0.9em;
    }
    .badge {
        vertical-align: middle;
    }
</style>
@endpush