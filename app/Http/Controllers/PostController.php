<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PostRepositoryInterface;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    public function index()
    {

        $posts= $this->postRepository->all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        //Post::create($validated);
        $this->postRepository->create($validated);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $post = $this->postRepository->find($id);
        $comments = $post->comments()->with('user')->latest()->paginate(10);
        $post->load('user');
        return view('posts.show', compact('post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = $this->postRepository->find($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $this->postRepository->update($id, $validated);

        return redirect()->route('posts.myPosts')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $this->postRepository->delete($id);

        return redirect()->route('posts.myPosts')->with('success', 'Post deleted successfully.');
    }
    public function myPosts()
    {

        $posts = $this->postRepository->getPostsByUserId(Auth::id());
        return view('posts.my_posts', compact('posts'));
    }
}
