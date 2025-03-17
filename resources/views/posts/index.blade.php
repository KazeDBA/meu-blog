@extends('layouts.app')

@section('title', 'Todos os Posts')

@section('content')
    <h1>Posts Recentes</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Novo Post</a>

    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">Ver Post</a>
            </div>
        </div>      
    @endforeach
@endsection