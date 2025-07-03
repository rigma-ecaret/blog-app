<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailComment;
use Illuminate\Support\Facades\Log;

class CommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new job instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $comment = $this->comment;

        $post = $comment->post;
        $postOwner = $post->user;

        // Checks if post owner exists and is not the same as the comment author
        if ($postOwner && $postOwner->id !== $comment->user_id) {
            // Send email to the post owner
            Mail::to($postOwner->email)->send(new EmailComment($post, $comment));
        }
    }
}
