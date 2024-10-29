<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{public function dashboard()
    {
        $query = Post::latest();
    
        if (auth()->check()) {
            $followingIds = auth()->user()->following()->pluck('users.id');
            $query->whereIn('user_id', $followingIds);
        }
    
        $posts = $query->get();
    
        return view('welcome', compact('posts'));
    }
    
    
    public function index()
    {
        $user = auth()->user();
        $followingIds = $user->following()->pluck('id');
        $posts = Post::whereIn('user_id', $followingIds)->with('comments')->get(); 
    
        return view('main', compact('user', 'posts'));
    }
    
    
}
