@extends('layouts.master')

@section('konten_utama')
  <h2 class="mb-lg">Katalog Produk</h2>

  <div class="grid grid-4">
    @forelse($products as $p)
    <div class="card">
      <div class="card-img">
          @if($p->image)
        <img src="{{ asset('assets/images/' . $p->image) }}" alt="{{$p->name}}">
          @else
        <div style="background-color: #eee;height: 150px;text-align: center;line-height: 150px;">
            Tanpa Gambar
        </div>
        @endif
      </div>
      <div class="card-body">
        <h4 class="card-title">{{ $p->name }}</h4>
        <p class="card-price mb-md">Rp. {{ number_format($p->price, 0, ',', '.') }}</p>
        <a href="/detail" class="btn btn-primary btn-block">Lihat Detail</a>
      </div>
    </div>
    @empty
    <div style="text-align: center;width: 100%;padding: 50px;">
        <h3 style="color: #888;">
            Mohon Maaf, Produk Belum Tersedia
        </h3>
    </div>
    @endforelse
  </div>
@endsection
