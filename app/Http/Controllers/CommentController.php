<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comments($start = 0, $limit = 10)
    {
        try {
            $comments = Comment::offset($start)->limit($limit)->get();
            $totalComments = Comment::count();

            //to check if any data is available
            $hasMoreData = ($totalComments > ($start + $limit)) ? true : false;

            return response()->json([
                'message'   => 'success',
                'comments'      => $comments,
                'hasMore' => $hasMoreData,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keywords');
        try {
            $comments = Comment::where('username', 'like', "%$keyword%")
                ->orWhere('comment', 'like', "%$keyword%")
                ->get();
            $totalComments = $comments->count();
            $hasMoreData = false;

            return response()->json([
                'comments' => $comments,
                'hasMore' => $hasMoreData,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
