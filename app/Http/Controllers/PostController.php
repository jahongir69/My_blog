<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    
    public function index()
    {
        $posts = Post::orderBy("created_at","desc")->paginate(6);
        return view("posts.index", compact("posts"));
    }

   
    public function create()
    {
       return view('posts.create');
    }
    protected function uploadImage($image)
    {
        $filePath = $image->store('images', 'public');
        return $filePath;
    }
    
  
    public function store(PostStoreRequest $request)
    {
        $postData = $request->validated();
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $postData['title'];
        $post->description = $postData['description'];
        $post->save();

        $uploadedImage = $this->uploadImage($request->file('image'));
        $post->image()->create([
            'image_path' => $uploadedImage
        ]);
        return redirect()->route('my.profile');
    }
    
    public function show(string $id)
    {
        $post = Post::findOrFail($id); 
        return view('posts.show', compact('post',));
    }
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('posts.editpost',compact('post',));
    }

    protected function deleteImage($imagePath)
{
    if (Storage::disk('public')->exists($imagePath)) {
        Storage::disk('public')->delete($imagePath);
    }
}

    public function update(PostUpdateRequest $request, string $id)
    {
        $postData = $request->validated();
        $post = Post::findOrFail($id);
        if($post->user_id !== Auth::id()){
            abort(403);
        }
        $post->title = $postData['title'];
        $post->description = $postData['description'];
        $post->save();

        if($request->hasFile("image")){
            if($post->image->image_path){
                $this->deleteImage($post->image->image_path);
            }
            $updatedImage = $this->uploadImage($request->file("image"));
            $post->image()->update([
                'image_path' => $updatedImage
            ]);
        }
        return redirect()->route('posts.show', $post->id);
    } 
    


    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
    
        if ($post->image) {
            $this->deleteImage($post->image->image_path);
        }
    
        $post->delete();
        return redirect()->route('my.profile');
    }

}
