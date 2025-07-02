<?php

namespace App\Repositories;
use \App\Models\Post;
class PostRepository implements PostRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function all(){
             return Post::all();
    }
    public function find($id){
        return Post::findOrFail($id);
    }

    public function create(array $data){
        return Post::create($data);
    }

    public function update($id, array $data){
        $post = Post::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id){
        $post = Post::findOrFail($id);
        return $post->delete();
    }
    public function getPostsByUserId($userId){
        return Post::where('user_id', $userId)->latest()->paginate(10); 
    }


}
