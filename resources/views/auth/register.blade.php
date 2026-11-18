@extends('auth.layout')

@section('judul', 'Daftar Akun - Wello')

@section('auth-content')
    <div class="auth-form-wrap">
        <div class="auth-header-text">
            <h2>Buat Akun Baru</h2>
            <p class="auth-intro">Bergabunglah dengan Wello untuk kemudahan berbelanja produk segar organik.</p>
        </div>

        <form class="auth-form" method="POST" action="{{ route('register.store') }}" x-data="{ showPw: false, showConfirm: false }">
            @csrf

            <div class="auth-field">
                <label for="name">Nama Lengkap</label>
                <div class="input-icon-wrapper">
                    <i data-lucide="user" class="input-icon"></i>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" autocomplete="name" required autofocus>
                </div>
                @error('name')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="email">Alamat Email</label>
                <div class="input-icon-wrapper">
                    <i data-lucide="mail" class="input-icon"></i>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" required>
                </div>
                @error('email')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password">Kata Sandi</label>
                <div class="input-icon-wrapper">
                    <i data-lucide="lock" class="input-icon"></i>
                    <input :type="showPw ? 'text' : 'password'" id="password" name="password" placeholder="Minimal 8 karakter" autocomplete="new-password" required>
                    <button type="button" @click="showPw = !showPw" class="toggle-pw" aria-label="Tampilkan kata sandi">
                        <span x-show="!showPw" style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </span>
                        <span x-show="showPw" x-cloak style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </span>
                    </button>
                </div>
                @error('password')
                    <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="password_confirmation">Ulangi Kata Sandi</label>
                <div class="input-icon-wrapper">
                    <i data-lucide="shield-check" class="input-icon"></i>
                    <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang kata sandi" autocomplete="new-password" required>
                    <button type="button" @click="showConfirm = !showConfirm" class="toggle-pw" aria-label="Tampilkan konfirmasi kata sandi">
                        <span x-show="!showConfirm" style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                        </span>
                        <span x-show="showConfirm" x-cloak style="display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </span>
                    </button>
                </div>
            </div>

            <button class="auth-submit-btn" type="submit">
                <span>Daftar Akun</span>
                <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
            </button>
        </form>

        <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk ke akun</a></p>
    </div>
@endsection
