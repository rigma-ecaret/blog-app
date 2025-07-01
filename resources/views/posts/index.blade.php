@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📃 All Posts</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @forelse($posts as $post)
        <div class="card mb-4 shadow-sm rounded-3">
            <div class="card-body">
                <h5 class="card-title text-dark">{{ $post->title }}</h5>


                <p class="text-muted small mb-2">
                    By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                </p>

                <p>{{ Str::limit($post->content, 150) }}</p>

                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">Read More</a>
            </div>
        </div>
    @empty
        <p>No posts found.</p>
    @endforelse
</div>
@endsection
