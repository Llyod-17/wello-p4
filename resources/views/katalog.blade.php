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
      @if(request('search'))
        Ditemukan <strong>{{ $products->count() }}</strong> produk untuk kata kunci "<strong>{{ request('search') }}</strong>"
        <a href="{{ request('sort') ? '/?sort=' . request('sort') : '/' }}" style="margin-left: 8px; color: var(--accent); font-weight: 600; text-decoration: underline;">Hapus Filter</a>
      @else
        Menampilkan <strong>{{ $products->count() }}</strong> produk berkualitas
      @endif
    </div>

    {{-- Auto-Submit Sorting Bar (SOP 3 - P11) --}}
    <form action="/" method="GET" class="sort-form-container">
      @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
      @endif
      <label for="sort" class="sort-label">Urutkan Harga:</label>
      <select name="sort" id="sort" onchange="this.form.submit()" class="sort-select">
        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Terbaru / Default</option>
        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
        <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
      </select>
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
        <h3 class="card-title">{{ $p->name }}</h3>
        <p class="card-price">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
        <a href="/detail/{{ $p->id }}" class="btn btn-primary btn-block">Lihat Detail</a>
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
