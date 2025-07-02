<?php

namespace App\Repositories;
use \App\Models\Comment;
class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function all(){

        return Comment::all();
    }
     public function find($id){
        return Comment::findOrFail($id);
    }

    public function create(array $data){
        return Comment::create($data);
    }

    public function update($id, array $data){
        $comment = Comment::findOrFail($id);
        $comment->update($data);
        return $comment;
    }

    public function delete($id){
        $comment = Comment::findOrFail($id);
        return $comment->delete();
    }
        public function getPostsByUserId($userId){
        return Comment::where('user_id', $userId)->latest()->paginate(10);
    }


}
