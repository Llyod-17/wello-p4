@extends('layouts.admin')

@section('judul', 'Tambah Produk Baru - Wello Back-Office')

@section('konten_admin')

    <!-- BREADCRUMB -->
    <div style="margin-bottom: 24px; font-size: 13.5px; color: var(--text-light); font-weight: 500; display: flex; align-items: center; gap: 8px;">
        <a href="/admin/products" style="color: var(--primary); text-decoration: none; font-weight: 600;">Katalog Produk</a>
        <i data-lucide="chevron-right" style="width: 14px; height: 14px; color: var(--border-subtle);"></i>
        <span style="color: var(--text-main); font-weight: 700;">Tambah Produk Baru</span>
    </div>

    <!-- VALIDATION ERRORS ALERT -->
    @if(isset($errors) && $errors->any())
        <div style="background-color: #FEF2F2; color: #991B1B; padding: 18px 22px; border-radius: 12px; border: 1.5px solid #FECACA; margin-bottom: 28px; font-size: 14px; box-shadow: var(--shadow-subtle);">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <i data-lucide="alert-circle" style="width: 18px; height: 18px;"></i>
                <strong style="font-size: 14.5px;">Gagal menyimpan produk, periksa kembali:</strong>
            </div>
            <ul style="margin: 0; padding-left: 28px; line-height: 1.6;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- MAIN FORM CARD -->
    <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); padding: 36px; box-shadow: var(--shadow-card);">
        
        <div style="border-bottom: 1.5px solid #F2F4EF; padding-bottom: 18px; margin-bottom: 32px;">
            <h2 style="margin: 0 0 6px 0; font-size: 20px; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">
                Informasi & Media Produk
            </h2>
            <p style="margin: 0; font-size: 14px; color: var(--text-muted);">
                Pastikan foto produk segar dan spesifikasi ditulis secara rinci untuk kenyamanan pembeli.
            </p>
        </div>

        <form action="/admin/products/store" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: flex; gap: 40px; align-items: flex-start; flex-wrap: wrap;">

                <!-- DROPZONE PHOTO UPLOAD (35%) -->
                <div style="flex: 1 1 320px; max-width: 400px;" x-data="{ isDragging: false }">
                    <label style="font-weight: 700; font-size: 14px; color: var(--text-main); display: block; margin-bottom: 6px;">
                        Foto Produk Utama <span style="color: #BA1A1A;">*</span>
                    </label>
                    <p style="font-size: 12.5px; color: var(--text-light); margin-top: 0; margin-bottom: 14px; line-height: 1.5;">
                        Format didukung: <strong>JPG, JPEG, PNG, WEBP</strong> (Maks 2 MB).
                    </p>

                    <!-- Interactive Drag-and-Drop Area -->
                    <div 
                        @dragover.prevent="isDragging = true" 
                        @dragleave.prevent="isDragging = false" 
                        @drop.prevent="isDragging = false"
                        :style="isDragging ? 'border-color: var(--primary); background-color: #EAEFD9;' : 'border-color: var(--border-subtle); background-color: #F8FAF5;'"
                        style="border: 2px dashed; border-radius: 14px; padding: 24px; text-align: center; margin-bottom: 14px; transition: all 0.2s ease; position: relative;">
                        
                        <img id="previewImage" src="" alt="Pratinjau Foto"
                             style="display: none; width: 100%; height: 240px; object-fit: cover; border-radius: 10px; margin-bottom: 14px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle);">

                        <div id="placeholderText" style="padding: 40px 12px; color: var(--text-light); font-size: 13.5px; line-height: 1.6;">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: #ECEFEA; color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto;">
                                <i data-lucide="upload-cloud" style="width: 24px; height: 24px;"></i>
                            </div>
                            <span style="font-weight: 700; color: var(--text-main); display: block; margin-bottom: 2px;">Pilih Berkas Foto</span>
                            Tarik foto ke sini atau klik tombol di bawah
                        </div>

                        <input type="file" name="image" id="imageInput"
                               accept="image/png, image/jpeg, image/jpg, image/webp" required
                               onchange="previewFile(this)"
                               style="width: 100%; font-size: 13px; color: var(--text-muted); padding-top: 8px;">
                    </div>
                </div>

                <!-- FORM FIELDS (65%) -->
                <div style="flex: 2 1 420px;">

                    <!-- Product Name -->
                    <div style="margin-bottom: 24px;">
                        <label style="font-weight: 700; font-size: 14px; color: var(--text-main); display: block; margin-bottom: 8px;">
                            Nama Produk <span style="color: #BA1A1A;">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="Contoh: Apel Fuji Manis Segar (kg)" required
                               style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border-subtle); border-radius: 10px; font-size: 14.5px; font-family: inherit; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-subtle)'">
                    </div>

                    <!-- Price Field -->
                    <div style="margin-bottom: 24px;">
                        <label style="font-weight: 700; font-size: 14px; color: var(--text-main); display: block; margin-bottom: 8px;">
                            Harga Satuan (Rupiah) <span style="color: #BA1A1A;">*</span>
                        </label>
                        <div style="display: flex; align-items: center; border: 1.5px solid var(--border-subtle); border-radius: 10px; overflow: hidden; background-color: #F8FAF5; transition: border-color 0.2s;" id="priceWrap">
                            <span style="padding: 12px 18px; font-weight: 800; color: var(--text-muted); font-size: 14.5px; border-right: 1.5px solid var(--border-subtle); background: #ECEFEA;">
                                Rp
                            </span>
                            <input type="number" name="price" value="{{ old('price') }}" min="100"
                                   placeholder="Contoh: 35000" required
                                   style="width: 100%; padding: 12px 16px; border: none; font-size: 15px; font-family: inherit; outline: none; background: #FFFFFF;"
                                   onfocus="document.getElementById('priceWrap').style.borderColor='var(--primary)'"
                                   onblur="document.getElementById('priceWrap').style.borderColor='var(--border-subtle)'">
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div style="margin-bottom: 32px;">
                        <label style="font-weight: 700; font-size: 14px; color: var(--text-main); display: block; margin-bottom: 8px;">
                            Deskripsi & Spesifikasi Lengkap <span style="color: #BA1A1A;">*</span>
                        </label>
                        <textarea name="description" rows="6"
                                  placeholder="Tuliskan spesifikasi, nutrisi, atau garansi kesegaran produk..." required
                                  style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border-subtle); border-radius: 10px; font-size: 14.5px; font-family: inherit; line-height: 1.6; box-sizing: border-box; outline: none; resize: vertical; transition: border-color 0.2s;"
                                  onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border-subtle)'">{{ old('description') }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; justify-content: flex-end; gap: 14px; border-top: 1.5px solid #F2F4EF; padding-top: 24px;">
                        <a href="/admin/products"
                           style="padding: 12px 24px; border-radius: 10px; border: 1.5px solid var(--border-subtle); color: var(--text-muted); text-decoration: none; font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; transition: all 0.2s;"
                           onmouseover="this.style.borderColor='var(--text-main)'; this.style.color='var(--text-main)'"
                           onmouseout="this.style.borderColor='var(--border-subtle)'; this.style.color='var(--text-muted)'">
                            Batal
                        </a>
                        <button type="submit"
                                style="padding: 12px 28px; border-radius: 10px; border: none; background-color: var(--primary); color: #FFFFFF; font-size: 14.5px; font-weight: 700; font-family: inherit; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: var(--shadow-subtle); transition: all 0.2s;"
                                onmouseover="this.style.backgroundColor='var(--primary-container)'; this.style.transform='translateY(-1px)'"
                                onmouseout="this.style.backgroundColor='var(--primary)'; this.style.transform='translateY(0)'">
                            <span>Simpan & Tampilkan Produk</span>
                            <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                        </button>
                    </div>

                </div>

            </div>
        </form>
    </div>

    <!-- Live Preview Script -->
    <script>
        function previewFile(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('previewImage');
                    const txt = document.getElementById('placeholderText');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    txt.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
