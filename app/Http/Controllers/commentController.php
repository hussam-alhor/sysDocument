<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;

class commentController extends Controller
{
    public function store(Request $request) 
    {
    $commentable_type = $request->input('commentable_type');
    $commentable_id = $request->input('commentable_id');
    $comment = new Comment();
    $comment->comment = $request->input('comment');
    $comment->commentable_type= $commentable_type;
    $comment->commentable_id =$commentable_id;
    $comment->save();

       return response()->json([
        'message'=>'success add'
       ],200);
    }
}
