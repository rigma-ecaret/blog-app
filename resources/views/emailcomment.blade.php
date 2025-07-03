<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Comment Notification</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; color: #222; }
        .container { background: #fff; padding: 24px; border-radius: 8px; max-width: 600px; margin: 24px auto; box-shadow: 0 2px 8px #e2e8f0; }
        .title { font-size: 22px; font-weight: bold; margin-bottom: 16px; }
        .post-title { font-weight: bold; color: #2563eb; }
        .comment { background: #f1f5f9; padding: 12px; border-radius: 6px; margin: 16px 0; font-style: italic; }
        .footer { margin-top: 32px; color: #888; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">New Comment Added</div>
        <div>A new comment has been added to the post: <span class="post-title">{{ $post->title }}</span></div>
        <div class="comment">{{ $comment->content }}</div>
        <div><strong>By:</strong> {{ $comment->user->name ?? 'Anonymous' }}</div>

    </div>
</body>
</html>
