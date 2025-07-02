@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Post Section -->
    <div class="mb-5">
        <h2 class="fw-bold">{{ $post->title }}</h2>
        <p class="text-muted mb-2">
            By <strong>{{ $post->user->name ?? 'Unknown User' }}</strong> •
            <small>{{ $post->created_at->format('M d, Y') }}</small>
        </p>
        <div class="p-3 bg-light rounded border">
            {{ $post->content }}
        </div>
    </div>

    <!-- Comments Section -->
    <div class="mb-5">
        <h4 class="mb-3">Comments</h4>
        @forelse($comments as $comment)
            <div class="mb-3 p-3 border rounded shadow-sm bg-white">
                <div class="d-flex justify-content-between">
                    <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>
                    <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <div class="mt-2">
                    {{ $comment->content }}
                </div>
            </div>
        @empty
            <p class="text-muted">No comments yet.</p>
        @endforelse
    </div>

    <!-- Add Comment Form -->
    <div class="mb-4">
        <h4 class="mb-3">Add a Comment</h4>
        <form action="{{ route('comments.store') }}" method="POST" class="border p-4 rounded bg-white shadow-sm">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="mb-3">
                <label for="content" class="form-label">Your Comment</label>
                <textarea
                    name="content"
                    id="content"
                    class="form-control @error('content') is-invalid @enderror"
                    rows="3"
                    placeholder="Write your comment..."
                    required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>
</div>
@endsection
