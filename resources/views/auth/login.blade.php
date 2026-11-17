@extends('auth.layout')

@section('judul', 'Masuk - Wello')

@section('auth-content')
    <div class="auth-form-wrap">
        <h2>Masuk</h2>

        @if (session('status'))
            <div class="auth-alert auth-alert-success" role="status">{{ session('status') }}</div>
        @endif

        @if (session('success'))
            <div class="auth-alert auth-alert-success" role="status">{{ session('success') }}</div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required autofocus>
                @error('email')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password">Kata sandi</label>
                <input id="password" name="password" type="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <button class="auth-submit" type="submit" aria-label="Masuk">
                <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </div>
@endsection
