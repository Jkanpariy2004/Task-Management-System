<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use App\Models\Comment As dbcomment;
use App\Models\Users As dbusers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Comment extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment_text' => 'required|max:255',
            'post_id' => 'required|integer',
        ]);

        $FetchUser = Session::get('email');
        $userData = DB::table('user')->where('email', $FetchUser)->first();
        $UserId = $userData->id;

        $comment = new dbcomment();
        $comment->user_id = $UserId;
        $comment->comment_text = $request['comment_text'];
        $comment->post_id = $request['post_id'];
        $comment->save();

        return response()->json([
            'success' => true,
            'user' => $userData, 
            'comment' => $comment
        ]);

        return response()->json($response);
    }

    public function fetch($post_id)
    {
        $comments = dbcomment::where('post_id', $post_id)->orderBy('created_at', 'desc')->get();
        $compact = compact('comments');
        return view('UserDashboard.User-Dashboard',$compact);
    }

    public function destroy($id)
    {
        $comment = dbcomment::find($id);
        
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false]);
    }


}
