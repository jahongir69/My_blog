@extends('layout.app')

@section('content')
<div class="container">
    <h2>Profil</h2>
    
    <div class="card">
        <div class="card-body">
            <h4>{{ auth()->user()->name }} ({{ auth()->user()->username }})</h4>
            <p>Email: {{ auth()->user()->email }}</p>

            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-thumbnail" width="150">
            @else
                <p>Profil rasmi yo‘q</p>
            @endif

            @if(auth()->check() && auth()->user()->id !== $user->id)
                @if(auth()->user()->following->contains($user->id))
                    <form action="{{ route('unfollow', $user->id) }}" method="POST">
                        @csrf
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
</div>
@endsection
