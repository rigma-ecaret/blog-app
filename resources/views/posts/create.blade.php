@extends('layouts.app')

@section('content')
@push('styles')
<style>
    body {
        background: #f1f5f9;
    }

    .custom-label {
        color: #1e293b;
        font-weight: 600;
    }

    .custom-btn-primary {
        background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
        border: none;
        transition: 0.3s ease;
        padding: 0.65rem 1.75rem;
        font-weight: 600;
        font-size: 1rem;
    }

    .custom-btn-primary:hover {
        background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
    }

    .card-form {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }

    .form-control {
        border-radius: 0.65rem;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        min-height: 45px;
        border: 1px solid #e2e8f0;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .center-wrapper {
        min-height: 75vh; /* reduced from 90vh */
        display: flex;
        align-items: start; /* changed from center */
        justify-content: center;
        padding: 1rem 0 2rem 0; /* reduced top space */
    }

    .col-form-wide {
        max-width: 620px; /* tighter form width */
        width: 100%;
    }

    .form-section {
        padding: 1.5rem 1.75rem; /* slightly reduced padding */
    }

    .card-header h3 {
        font-size: 1.5rem;
    }
</style>
@endpush
<div class="container center-wrapper">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-md-10 col-form-wide">
            <div class="card card-form">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h3 class="fw-bold text-dark mb-0">📝 Create a New Blog Post</h3>
                    <p class="text-muted mt-2 mb-0">Share your thoughts with the community</p>
                </div>

                <div class="form-section">
                    <form action="{{ route('posts.store') }}" method="POST">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label custom-label">Post Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="e.g. My Laravel Journey" required>
                        </div>

                        {{-- Content --}}
                        <div class="mb-3">
                            <label for="content" class="form-label custom-label">Post Content</label>
                            <textarea name="content" id="content" class="form-control" rows="6" placeholder="Write your blog content here..." required></textarea>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn custom-btn-primary text-white">Publish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
