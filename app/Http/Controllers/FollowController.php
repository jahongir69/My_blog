<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if (Auth::id() !== $user->id) {
            Auth::user()->following()->attach($user->id);
            $user->notify(new NewFollowerNotification(Auth::user()));

            return back()->with('success', 'You are now following ' . $user->name);
        }

        return back()->with('error', 'You cannot follow yourself.');
    }

    public function unfollow(User $user)
    {
        Auth::user()->following()->detach($user->id);

        return back()->with('success', 'You have unfollowed ' . $user->name);
    }
}
