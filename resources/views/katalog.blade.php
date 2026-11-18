@extends('layouts.master')

@section('judul', 'Katalog Produk - Wello Vitality Grocer')

@section('konten_utama')
  {{-- Store Banner (Brand Customization - P11) --}}
  <div class="store-banner">
    <div>
      <span class="badge badge-accent mb-sm">Pasar Segar &amp; Organik</span>
      <h1>Wello Vitality Grocer</h1>
      <p>Pasokan bahan makanan segar, sayur-mayur, dan buah pilihan berkualitas tinggi langsung untuk keluarga Anda.</p>
    </div>
  </div>

  {{-- Sorting & Search Info Bar (P11) --}}
  <div class="catalog-controls">
    <div class="catalog-info" id="catalog-info">
      @if(request('search') || request('category'))
        Ditemukan <strong>{{ $products->count() }}</strong> produk
        @if(request('search')) untuk kata kunci "<strong>{{ request('search') }}</strong>"@endif
        @if(request('category')) dalam kategori "<strong>{{ request('category') }}</strong>"@endif
        <a href="/" style="margin-left: 8px; color: var(--accent); font-weight: 600; text-decoration: underline;">Reset Filter</a>
      @else
        Menampilkan <strong>{{ $products->count() }}</strong> produk berkualitas
      @endif
    </div>

    {{-- Category & Sorting Bar --}}
    <form action="/" method="GET" class="sort-form-container" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
      @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
      @endif

      <div style="display: flex; align-items: center; gap: 6px;">
        <label for="category" class="sort-label">Kategori:</label>
        <select name="category" id="category" onchange="this.form.submit()" class="sort-select">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>

      <div style="display: flex; align-items: center; gap: 6px;">
        <label for="sort" class="sort-label">Urutan:</label>
        <select name="sort" id="sort" onchange="this.form.submit()" class="sort-select">
          <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Terbaru</option>
          <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
          <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
        </select>
      </div>
    </form>
  </div>

  {{-- Product Grid --}}
  <div class="grid grid-4" id="products-grid">
    @forelse($products as $p)
    <div class="card product-card-item" data-product-item data-name="{{ strtolower($p->name) }}" data-desc="{{ strtolower($p->description ?? '') }}">
      <div class="card-img">
        @if($p->image)
          <img src="{{ asset('assets/images/' . $p->image) }}" alt="{{ $p->name }}">
        @else
          <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--surface-dim); color: var(--text-light); font-size: 0.875rem;">
            Tanpa Gambar
          </div>
        @endif
      </div>
      <div class="card-body">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
          <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--primary-dark, #3C6A00); background: #EAEFD9; padding: 2px 8px; border-radius: 9999px;">
            {{ $p->category ?? 'Umum' }}
          </span>
          <span style="font-size: 12px; color: {{ $p->stock > 0 ? 'var(--text-muted)' : '#BA1A1A' }}; font-weight: 600;">
            @if($p->stock > 0)
              Stok: {{ $p->stock }}
            @else
              Stok Habis
            @endif
          </span>
        </div>
        <h3 class="card-title">{{ $p->name }}</h3>
        <p class="card-price">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
        @if($p->stock > 0)
          <a href="/detail/{{ $p->id }}" class="btn btn-primary btn-block">Lihat Detail</a>
        @else
          <button type="button" class="btn btn-block" disabled style="background: #E0E3DB; color: #8C9382; cursor: not-allowed; border: none;">Stok Habis</button>
        @endif
      </div>
    </div>
    @empty
    {{-- Empty Search State (SOP & QA C.4 - P11) --}}
    <div class="empty-state">
      <h3>Produk Tidak Ditemukan</h3>
      <p>
        @if(request('search'))
          Mohon maaf, tidak ada produk yang sesuai dengan kata kunci "<strong>{{ request('search') }}</strong>".
        @else
          Mohon maaf, produk belum tersedia di katalog saat ini.
        @endif
      </p>
      <a href="/" class="btn btn-outline">Lihat Semua Produk</a>
    </div>
    @endforelse

    {{-- Live client-side empty state when dynamic filter hides all --}}
    <div class="empty-state" id="live-empty-state" style="display: none; grid-column: 1 / -1;">
      <h3>Produk Tidak Ditemukan</h3>
      <p>Mohon maaf, tidak ada produk yang sesuai dengan kata kunci "<strong id="live-empty-term"></strong>".</p>
      <button type="button" class="btn btn-outline" id="live-reset-btn">Lihat Semua Produk</button>
    </div>
  </div>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.querySelector('[data-live-search]');
      const items = Array.from(document.querySelectorAll('[data-product-item]'));
      const emptyState = document.getElementById('live-empty-state');
      const emptyTerm = document.getElementById('live-empty-term');
      const resetBtn = document.getElementById('live-reset-btn');
      const infoContainer = document.getElementById('catalog-info');
      const totalCount = items.length;

      if (!searchInput || items.length === 0) return;

      function performLiveSearch(term) {
        const query = term.trim().toLowerCase();
        let visibleCount = 0;

        items.forEach(item => {
          const name = item.getAttribute('data-name') || '';
          const desc = item.getAttribute('data-desc') || '';
          const matches = name.includes(query) || desc.includes(query);

          if (matches) {
            item.style.display = '';
            visibleCount++;
          } else {
            item.style.display = 'none';
          }
        });

        if (emptyState) {
          if (visibleCount === 0 && query !== '') {
            emptyState.style.display = 'flex';
            if (emptyTerm) emptyTerm.textContent = term;
          } else {
            emptyState.style.display = 'none';
          }
        }

        if (infoContainer) {
          if (query !== '') {
            infoContainer.innerHTML = `Ditemukan <strong>${visibleCount}</strong> produk untuk kata kunci "<strong>${escapeHtml(term)}</strong>" <button type="button" id="live-clear-inline" style="background: none; border: none; margin-left: 8px; color: var(--accent); font-weight: 600; text-decoration: underline; cursor: pointer; padding: 0; font-family: inherit;">Hapus Filter</button>`;
            const clearBtn = document.getElementById('live-clear-inline');
            if (clearBtn) clearBtn.addEventListener('click', clearSearch);
          } else {
            infoContainer.innerHTML = `Menampilkan <strong>${totalCount}</strong> produk berkualitas`;
          }
        }
      }

      function clearSearch() {
        searchInput.value = '';
        performLiveSearch('');
        searchInput.focus();
      }

      function escapeHtml(str) {
        return str.replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[m]);
      }

      searchInput.addEventListener('input', (e) => {
        performLiveSearch(e.target.value);
      });

      if (resetBtn) {
        resetBtn.addEventListener('click', clearSearch);
      }
    });
  </script>
  @endpush
@endsection
