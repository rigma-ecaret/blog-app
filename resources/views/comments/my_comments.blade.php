@extends('layouts.app')

@section('content')
<div class="container py-4 px-4">
    <h2 class="mb-4 fw-bold">Your Comments</h2>

    <div class="row g-4">
        @forelse($comments as $comment)
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card shadow border-0 w-100 h-100">

                <div class="card-body d-flex flex-column">

                    <p class="card-text flex-grow-1">Content : {{ Str::limit($comment->content, 120) }}</p>
                </div>
                <div class="card-footer bg-light text-muted small d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar-event me-1"></i> {{ $comment->created_at->format('M d, Y') }}</span>
                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">No comments available.</div>
        </div>
        @endforelse
    </div>


</div>
@endsection
