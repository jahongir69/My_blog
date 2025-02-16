@extends('layout.app')
@section('content')
<main class="flex-grow container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="flex flex-col sm:flex-row items-center mb-4">
                @if($user->image && $user->image->image_path)
                    <img src="{{ asset('storage/' . $user->image->image_path) }}" alt="User Avatar" class="w-20 h-20 rounded-full mr-4 mb-4 sm:mb-0">
                @else
                    <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" class="w-20 h-20 rounded-full mr-4 mb-4 sm:mb-0">
                @endif
                <div class="text-center sm:text-left flex-grow">
                    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $user->username }}</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-auto">
                    @if(auth()->check() && auth()->user()->id !== $user->id)
                        @if(auth()->user()->following->contains($user->id))
                            <form action="{{ route('unfollow', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Unfollow</button>
                            </form>
                        @else
                            <form action="{{ route('follow', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Follow</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap justify-center sm:justify-start space-x-4">
                <span class="font-semibold">{{ $user->followers()->count() . ' Followers' }}</span>
                <span class="font-semibold">{{ $user->following()->count() . ' Following' }}</span>
                <span class="font-semibold">{{ $user->posts()->count() . ' Post' }}</span>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4">User's Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($user->posts as $post)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    @if($post->image && $post->image->image_path)
                        <img src="{{ asset('storage/' . $post->image->image_path) }}" alt="Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                    @else
                        <img src="{{ asset('default-post.png') }}" alt="Default Post Image" class="w-full h-48 object-cover rounded-lg mb-4">
                    @endif
                    <h3 class="text-xl font-bold mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-700 mb-4">{{ $post->description }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-800">Read More</a>
                </div>
            @endforeach
        </div>
    </div>
</main>
@endsection