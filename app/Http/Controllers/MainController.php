<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function dashboard(){
        $posts = Post::all();
        return view('welcome',compact('posts'));
    }
    public function index(){
        $user =Auth::user(); 
        $posts = Post::with('comments')->get();
        return view('main',compact('user','posts'));
    }
    
}
