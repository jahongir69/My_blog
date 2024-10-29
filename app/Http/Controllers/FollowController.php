<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class FollowController extends Controller{
     public function follow(User $user)
     {
         if (auth()->user()->id !== $user->id) {
             auth()->user()->following()->attach($user->id);
             $user->notify(new NewFollowerNotification(auth()->user()));
         }
         
         return back();
     }
     
     public function unfollow($id){
          $userToUnfollow = User::findOrFail($id);
          auth()->user()->following()->detach($userToUnfollow->id);
          return redirect()->back()->with('success', 'You have unfollowed ' . $userToUnfollow->name);
     }
}