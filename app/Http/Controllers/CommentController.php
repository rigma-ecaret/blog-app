<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CommentRepositoryInterface;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository){

        $this->commentRepository = $commentRepository;
    }



     public function index()
    {
        $comments = $this->commentRepository->all();
        return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    $validated = $request->validate([
     'content' => 'required|string|max:1000',
     'post_id' => 'required|exists:posts,id',

    ]);

    $validated['user_id'] = Auth::id();

    // Comment::create($validated);
    $this->commentRepository->create($validated);

  return redirect()->route('posts.show', $validated['post_id'])->with('success', 'Comment added successfully.');

}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $comment = $this->commentRepository->find($id);
        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }
        return view('comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $comment = $this->commentRepository->find($id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $this->commentRepository->update($id, $validated);

        return redirect()->route('comments.myComments')->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->commentRepository->delete($id);
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function myComments()
    {

        $comments= $this->commentRepository->getPostsByUserId(Auth::id());
        return view('comments.my_comments', compact('comments'));
    }

}
