@extends('layouts.master')

@section('judul', 'Katalog Produk - Wello Vitality Grocer')

@section('konten_utama')
  @if(session('success'))
    <div style="background-color: #EAEFD9; color: var(--primary-dark, #3C6A00); padding: 14px 18px; border-radius: 10px; border: 1px solid #C2C9B5; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; justify-content: space-between;">
      <span>✓ {{ session('success') }}</span>
      <a href="{{ route('cart.index') }}" style="color: var(--primary-dark, #3C6A00); font-size: 13px; text-decoration: underline;">Lihat Keranjang →</a>
    </div>
  @endif

  @if(session('error'))
    <div style="background-color: #FFF4F2; color: #BA1A1A; padding: 14px 18px; border-radius: 10px; border: 1px solid #FFDAD6; margin-bottom: 20px; font-weight: 700;">
      <span>✕ {{ session('error') }}</span>
    </div>
  @endif

  {{-- Store Banner (Sapaan Dinamis & Penyesuaian Brand) --}}
  <div class="store-banner">
    <div style="position: relative; z-index: 2;">
      @auth
        <h1>Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p>Siap penuhi kebutuhan dapur hari ini? Temukan aneka buah manis, sayur renyah, dan rempah segar pilihan langsung dari kebun terbaik.</p>
      @else
        <h1>Selamat Datang di Wello! 🌿</h1>
        <p>Belanja sayur segar, buah pilihan, dan kebutuhan dapur berkualitas tinggi — higienis, hemat, dan diantar cepat langsung ke rumah Anda.</p>
      @endauth
    </div>

    <!-- Ornamen Badge Kanan (Memberi Sentuhan Visual Modern & Tidak Polos) -->
  </div>

  {{-- Category Pills (Inovasi Fitur UI) --}}
  <div style="margin-bottom: 24px; display: flex; gap: 8px; flex-wrap: wrap;">
    <a href="/" 
       style="padding: 8px 16px; border-radius: 9999px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.2s; border: 1.5px solid {{ request('category') ? 'var(--border, #C2C9B5)' : 'var(--primary, #7CB342)' }}; background: {{ request('category') ? 'transparent' : 'var(--primary, #7CB342)' }}; color: {{ request('category') ? 'var(--text-muted, #424939)' : '#FFFFFF' }};"
       onmouseover="this.style.borderColor='var(--primary, #7CB342)'; this.style.color='var(--primary-dark, #3C6A00)';"
       onmouseout="this.style.borderColor='{{ request('category') ? 'var(--border, #C2C9B5)' : 'var(--primary, #7CB342)' }}'; this.style.color='{{ request('category') ? 'var(--text-muted, #424939)' : '#FFFFFF' }}';">
       Semua
    </a>
    @foreach($categories as $cat)
    <a href="/?category={{ urlencode($cat) }}"
       style="padding: 8px 16px; border-radius: 9999px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.2s; border: 1.5px solid {{ request('category') == $cat ? 'var(--primary, #7CB342)' : 'var(--border, #C2C9B5)' }}; background: {{ request('category') == $cat ? 'var(--primary, #7CB342)' : 'transparent' }}; color: {{ request('category') == $cat ? '#FFFFFF' : 'var(--text-muted, #424939)' }};"
       onmouseover="this.style.borderColor='var(--primary, #7CB342)'; this.style.background='var(--primary, #7CB342)'; this.style.color='#FFFFFF';"
       onmouseout="this.style.borderColor='{{ request('category') == $cat ? 'var(--primary, #7CB342)' : 'var(--border, #C2C9B5)' }}'; this.style.background='{{ request('category') == $cat ? 'var(--primary, #7CB342)' : 'transparent' }}'; this.style.color='{{ request('category') == $cat ? '#FFFFFF' : 'var(--text-muted, #424939)' }}';">
       {{ $cat }}
    </a>
    @endforeach
  </div>

  {{-- Sorting Bar --}}
  <div class="catalog-controls" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
    <div class="catalog-info" id="catalog-info" style="font-size: 14px;">
      @if(request('search') || request('category'))
        Ditemukan <strong>{{ $products->count() }}</strong> produk
        @if(request('search')) untuk kata kunci "<strong>{{ request('search') }}</strong>"@endif
        @if(request('category')) dalam kategori "<strong>{{ request('category') }}</strong>"@endif
      @else
        Menampilkan <strong>{{ $products->count() }}</strong> produk berkualitas
      @endif
    </div>

    <form action="/" method="GET" style="display: flex; gap: 6px; align-items: center;">
      @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
      @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
      
      <select name="sort" onchange="this.form.submit()" 
              style="padding: 8px 12px; border-radius: 8px; border: 1px solid var(--border, #C2C9B5); font-size: 13px; font-weight: 600; cursor: pointer; outline: none;">
        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Terbaru</option>
        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Rendah → Tinggi</option>
        <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Tinggi → Rendah</option>
      </select>
    </form>
  </div>

  {{-- Product Grid --}}
  <div class="grid grid-4" id="products-grid">
    @forelse($products as $p)
    <div class="card product-card-item" data-product-item data-name="{{ strtolower($p->name) }}" data-desc="{{ strtolower($p->description ?? '') }}"
         style="transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 16px; border: 1px solid var(--border, #C2C9B5); overflow: hidden; background: #FFFFFF; display: flex; flex-direction: column;"
         onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(27,48,34,0.08)';"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
      
      <div class="card-img" style="position: relative; aspect-ratio: 1 / 1; overflow: hidden; background: #F8FAF5;">
        @if($p->image)
          <img src="{{ asset('assets/images/' . $p->image) }}" alt="{{ $p->name }}"
               style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
               onmouseover="this.style.transform='scale(1.05)';"
               onmouseout="this.style.transform='scale(1)';">
        @else
          <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #F5F7F2; color: var(--text-light); font-size: 0.875rem;">
            Tanpa Gambar
          </div>
        @endif

        <!-- Floating Category Badge -->
        <span style="position: absolute; top: 10px; left: 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #3C6A00; background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(6px); padding: 4px 10px; border-radius: 9999px; box-shadow: 0 2px 6px rgba(0,0,0,0.06);">
          {{ $p->category ?? 'Umum' }}
        </span>
      </div>

      <div class="card-body" style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <span style="font-size: 11.5px; color: {{ $p->stock > 0 ? ($p->stock <= 5 ? '#E65100' : 'var(--text-muted)') : '#BA1A1A' }}; font-weight: 700;">
              @if($p->stock > 0)
                {{ $p->stock <= 5 ? 'Sisa ' . $p->stock . ' unit!' : 'Stok: ' . $p->stock }}
              @else
                Stok Habis
              @endif
            </span>
          </div>

          <h3 class="card-title" style="font-size: 15px; font-weight: 700; color: var(--text, #191C1A); margin: 0 0 6px 0; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 40px;">
            {{ $p->name }}
          </h3>

          <div style="display: flex; align-items: baseline; gap: 4px; margin-bottom: 12px;">
            <span style="font-size: 13px; font-weight: 600; color: var(--text-light);">Rp</span>
            <span style="font-size: 18px; font-weight: 800; color: #3C6A00; letter-spacing: -0.01em;">
              {{ number_format($p->price, 0, ',', '.') }}
            </span>
          </div>
        </div>

        @if($p->stock > 0)
          <div style="display: flex; gap: 8px; margin-top: 8px;">
            <a href="/detail/{{ $p->id }}" 
               style="flex: 1; text-align: center; text-decoration: none; padding: 10px 12px; font-size: 13px; font-weight: 700; background: #7CB342; color: #FFFFFF; border-radius: 8px; transition: all 0.2s;"
               onmouseover="this.style.background='#689F38';"
               onmouseout="this.style.background='#7CB342';">
              Detail
            </a>
            @auth
              <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $p->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        style="width: 38px; height: 38px; border: 1.5px solid #7CB342; background: #FFFFFF; color: #3C6A00; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px; transition: all 0.2s ease;"
                        onmouseover="this.style.background='#EAEFD9';"
                        onmouseout="this.style.background='#FFFFFF';"
                        title="Tambah 1 ke Keranjang">
                  🛒
                </button>
              </form>
            @endauth
          </div>
        @else
          <button type="button" disabled style="width: 100%; padding: 10px; background: #E0E3DB; color: #8C9382; cursor: not-allowed; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; margin-top: 8px;">
            Stok Habis
          </button>
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
