<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FollowController extends Controller{
    public function follow($id){
        $user = User::find($id);
         $user->following()->attach($user->id);
         $user->notify(new NewFollowerNotification(Auth::user()));
          return redirect()->back();
     }
     public function unfollow($id){
        $user = User::find($id);
         $user->following()->detach($user->id);
          return redirect()->back();
     }
}
