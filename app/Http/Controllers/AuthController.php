<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthEditRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendSmsToEmail;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request ;
use Illuminate\Support\Facades\Storage;
class AuthController extends Controller
{
   public function registerForm(){
    return view('auth.register');
   }
   protected function uploadAvatar($avatar)
{
    $filePath = $avatar->store('image', 'public');
    return $filePath;
}
public function register(AuthRegisterRequest $request)
{
    $uploadedAvatar = null;
    if ($request->hasFile('avatar')) {
        $uploadedAvatar = $this->uploadAvatar($request->file('avatar'));
    }
    $user = new User();
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->verification_token = uniqid();
    $user->password = bcrypt($request->password);
    $user->save();
    if ($uploadedAvatar) {
        $user->image()->create([
            'image_path' => $uploadedAvatar,
        ]);
    }
    Mail::to($user->email)->send(new SendSmsToEmail($user));
    
    return redirect()->route('loginForm');
}

   public function loginForm(){
      return view('auth.login');
  }

  public function login(AuthLoginRequest $request) {
      $user = User::where('email', $request->email)->first();
      if ($user && Hash::check($request->password, $user->password)) {
        if($user->email_verified_at != null){
            Auth::attempt(["email"=> $request->email,"password"=> $request->password]);
            return redirect()->route("home");
        }
      }
  }
  public function editForm($id){
    $user = User::findorFail($id);
    if($user->id !== Auth::id()){
        return redirect()->route('my.profile');
    } else{
    $posts = Post::with('comments')->get();
    return view('auth.edit',compact('user','posts'));
  }
}
  public function update(AuthEditRequest $request, ) 
  {
    $id = Auth::id();
      $user =  User::find($id);
      $requestData = $request->validated();
  
      $user->name = $requestData['name'];
      $user->username = $requestData['username'];
      $user->email = $requestData['email'];
  
      if (!empty($request->old_password)) {
          if (!Hash::check($request->old_password, $user->password)) {
              return redirect()->back()->with("error", "This password is incorrect");
          }
          $user->password = bcrypt($requestData['new_password']);
      }
  
      $user->save();
  
     
      if($request->hasFile("avatar")){
        if($user->image->image_path){
            $this->deleteAvatar($user->image->image_path);
        }
        $uploadedAvatar = $this->uploadAvatar($request->file('avatar'));
        $user->image()->update([
            'image_path'=> $uploadedAvatar
        ]);
    }
  
      return redirect()->route('my.profile');
  }
  



  protected function deleteAvatar($path)
  {

      Storage::disk('public')->delete($path);
  }
  

  public function logout(Request $request)
  {
      Auth::logout(); 
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect()->route('loginForm'); 
    }
    public function emailVerify(Request $request){
        $user = User::where('verification_token', $request->token)->first();
        if(!$user || $user->verification_token !== $request->token){
            abort(404);
        }

        $user->email_verified_at = now();
        $user->save();
        return redirect()->route('loginForm');
    }
    

public function notify(){
   $notify = Auth::user()->notifications;
   return view('auth.notify',compact('notify'));
}
public function userprofile($id) {
    $user = User::where('username', $id)->first();
    if(!$user){
        abort(404);
    }
    return view("posts.profile", compact("user"));
}
public function my_profile()
{
    $user = auth()->user(); 

    $posts = $user->posts()->orderBy("created_at", "desc")->paginate(4); 
    
    return view("auth.myprofile", compact("user", "posts"));
}


}