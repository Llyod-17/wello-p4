@extends('auth.layout')

@section('judul', 'Masuk - Wello')

@section('auth-content')
    <div class="auth-form-wrap">
        <div class="auth-header-text">
            <h2>Selamat Datang Kembali</h2>
            <p class="auth-intro">Masuk untuk menikmati belanja buah & sayur segar pilihan.</p>
        </div>

        @if (session('status'))
            <div class="auth-alert auth-alert-success" role="status">
                <i data-lucide="check-circle" class="alert-icon"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="auth-alert auth-alert-success" role="status">
                <i data-lucide="check-circle" class="alert-icon"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-field">
                <label for="email">Alamat Email</label>
                <div class="input-icon-wrapper">
                    <i data-lucide="mail" class="input-icon"></i>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required autofocus>
                </div>
                @error('email')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field" x-data="{ show: false }">
                <label for="password">Kata Sandi</label>
                <div class="input-icon-wrapper">
                    <i data-lucide="lock" class="input-icon"></i>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" placeholder="Masukkan kata sandi" autocomplete="current-password" required>
                    <button type="button" @click="show = !show" class="toggle-pw" aria-label="Tampilkan kata sandi">
                        <span x-show="!show" style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </span>
                        <span x-show="show" x-cloak style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </span>
                    </button>
                </div>
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <button class="auth-submit-btn" type="submit">
                <span>Masuk Sekarang</span>
                <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
            </button>
        </form>

        <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
    </div>
@endsection
