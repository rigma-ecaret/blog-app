@extends('layouts.app')

@section('content')
<div class="container py-4 px-4">
    <h2 class="mb-4 fw-bold">All Posts</h2>

    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                <div class="card shadow border-0 w-100 h-100">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="bi bi-person-circle fs-4 me-2"></i>
                        <span class="card-title fw-bold text-dark" style="color: #212529 !important;">
                            {{ $post->user->name ?? 'Unknown User' }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-dark">{{ $post->title }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($post->content, 120) }}</p>
                    </div>
                    <div class="card-footer bg-light text-muted small d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('M d, Y') }}</span>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No posts available.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
