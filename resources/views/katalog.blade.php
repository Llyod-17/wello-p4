@extends('layouts.master')

@section('konten_utama')
  <h2 class="mb-lg">Katalog Produk</h2>

  <div class="grid grid-4">
    {{-- Product Card 1 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400&h=400&fit=crop" alt="Apel Segar">
      </div>
      <div class="card-body">
        <h4 class="card-title">Apel Segar</h4>
        <p class="card-price mb-md">Rp 35.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 2 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1587132137056-bfbf0166836e?w=400&h=400&fit=crop" alt="Wortel Organik">
      </div>
      <div class="card-body">
        <h4 class="card-title">Wortel Organik</h4>
        <p class="card-price mb-md">Rp 25.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 3 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1601004890684-d8cbf643f5f2?w=400&h=400&fit=crop" alt="Bayam Segar">
      </div>
      <div class="card-body">
        <h4 class="card-title">Bayam Segar</h4>
        <p class="card-price mb-md">Rp 15.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 4 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1550258987-190a2d41a8ba?w=400&h=400&fit=crop" alt="Jeruk Manis">
      </div>
      <div class="card-body">
        <h4 class="card-title">Jeruk Manis</h4>
        <p class="card-price mb-md">Rp 45.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 5 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1459411621453-7b03977f4bfc?w=400&h=400&fit=crop" alt="Brokoli">
      </div>
      <div class="card-body">
        <h4 class="card-title">Brokoli</h4>
        <p class="card-price mb-md">Rp 20.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 6 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=400&fit=crop" alt="Tomat Merah">
      </div>
      <div class="card-body">
        <h4 class="card-title">Tomat Merah</h4>
        <p class="card-price mb-md">Rp 30.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 7 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1597714026720-8f74c62310ba?w=400&h=400&fit=crop" alt="Kentang">
      </div>
      <div class="card-body">
        <h4 class="card-title">Kentang</h4>
        <p class="card-price mb-md">Rp 28.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>

    {{-- Product Card 8 --}}
    <div class="card">
      <div class="card-img">
        <img src="https://images.unsplash.com/photo-1603833665858-e61d17a86224?w=400&h=400&fit=crop" alt="Lemon">
      </div>
      <div class="card-body">
        <h4 class="card-title">Lemon</h4>
        <p class="card-price mb-md">Rp 18.000</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>
  </div>
@endsection