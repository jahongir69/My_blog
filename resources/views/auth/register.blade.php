@extends('layout.app')

@section('title', 'Register')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-50" style="border-radius: 10px; background-color: #f8f9fa;">
        <h2 class="text-center text-primary mb-4">Ro‘yxatdan o‘tish</h2>
        
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Ism</label>
                <input type="text" name="name" class="form-control border-primary" value="{{ old('name') }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Foydalanuvchi nomi</label>
                <input type="text" name="username" class="form-control border-primary" value="{{ old('username') }}">
                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control border-primary" value="{{ old('email') }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Parol</label>
                <input type="password" name="password" class="form-control border-primary">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-bold">Parolni tasdiqlang</label>
                <input type="password" name="password_confirmation" class="form-control border-primary">
            </div>
            
            <div class="mb-3">
                <label for="avatar" class="form-label fw-bold">Profil rasmi (ixtiyoriy)</label>
                <input type="file" name="avatar" class="form-control border-primary">
                @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Ro‘yxatdan o‘tish</button>
            </div>
        </form>
    </div>
</div>
@endsection
