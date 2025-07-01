@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold">{{ $post->title }}</h2>
        <p class="text-muted">
            By {{ $post->user->name ?? 'Unknown User' }} • {{ $post->created_at->format('M d, Y') }}
        </p>
        <div class="mb-3">
            {{ $post->content }}
        </div>
    </div>

    <hr>

    <h5>Comments</h5>
    @forelse($comments as $comment)
        <div class="mb-2 p-2 border rounded">
            <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
            <span class="text-muted small">• {{ $comment->created_at->diffForHumans() }}</span>
            <div>{{ $comment->content }}</div>
        </div>
    @empty
        <p>No comments yet.</p>
    @endforelse

    <hr>
    <h5>Add a Comment</h5>
    <form action="{{ route('comments.store', $post->id)}}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="Write your comment..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>
</div>
@endsection
