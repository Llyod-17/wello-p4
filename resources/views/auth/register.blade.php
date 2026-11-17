@extends('auth.layout')

@section('judul', 'Daftar - Wello')

@section('auth-content')
    <div class="auth-form-wrap">
        <h2>Daftar</h2>
        <p class="auth-intro">Buat akun untuk berbelanja segar setiap hari.</p>

        <form class="auth-form" method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="auth-field">
                <label for="name">Nama lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Nama kamu" autocomplete="name" required autofocus>
                @error('name')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required>
                @error('email')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password">Kata sandi</label>
                <input id="password" name="password" type="password" placeholder="Minimal 8 karakter" autocomplete="new-password" required>
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password_confirmation">Ulangi kata sandi</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi kata sandi" autocomplete="new-password" required>
            </div>

            <button class="auth-submit" type="submit" aria-label="Buat akun">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
@endsection
