# LEMBAR KERJA PESERTA DIDIK

## PERTEMUAN 11

INSTRUMEN PENGUJIAN FITUR PENCARIAN (LIKE), PENGURUTAN HARGA (orderBy),
& MARKETPLACE UI

## A. IDENTITAS PROYEK KELOMPOK

Nama Merek / Toko :
.........................................................................

Sektor E-Commerce :
.........................................................................

Pembagian Peran Pengujian :

Project Manager (QC Lead) :
.........................................................................

UI/UX Designer (Frontend) :
.........................................................................

Backend Developer (DB) :
.........................................................................

## B. CHECKLIST KONFIGURASI SEARCH, SORTING, & BRAND UI (Wajib dicentang oleh Project Manager setelah melihat langsung pekerjaan tim)

| No \| Instruksi Kerja Fungsional (SOP) \| Status \| TTD PM \|

| --- \| --- \| --- \| --- \|

| 1 \| Global Search Header: File master.blade.php telah memiliki form
  pencarian GET yang mempertahankan nilai request('search'). \| \[ \] \|
  ............... \|

| 2 \| Search & Sort Query: Fungsi index(Request \$request) di
  ProductController telah menerapkan LIKE dan orderBy(). \| \[ \] \|
  ............... \|

| 3 \| Auto-Submit Sorting Bar: Dropdown urutkan harga di
  katalog.blade.php telah menggunakan onchange="this.form.submit()". \|
  \[ \] \| ............... \|

| 4 \| Brand Customization: Nama toko dan kode warna HEX pada
  Header/Banner telah disesuaikan dengan identitas kelompok. \| \[ \] \|
  ............... \|

## C. MATRIKS PENGUJIAN PENCARIAN & FILTER HARGA (QUALITY ASSURANCE) (Eksekusi di peramban Google Chrome dan tandai status kelulusannya)

| Skenario Pengujian Sistem Terpadu \| Target yang Diharapkan (Expected
  Result) \| Status Kelulusan \|

| --- \| --- \| --- \|

| Uji Pencarian Nama & Deskripsi (LIKE) \| Mengetik potongan kata produk
  di Search Bar berhasil menyaring katalog dan menampilkan jumlah barang
  yang ditemukan. \| \[ \] PASS \[ \] FAIL \|

| Uji Pengurutan Harga Termurah (asc) \| Memilih opsi "Harga: Rendah ke
  Tinggi" berhasil menyusun kartu produk mulai dari nominal harga paling
  murah di kiri atas. \| \[ \] PASS \[ \] FAIL \|

| Uji Pengurutan Harga Termahal (desc) \| Memilih opsi "Harga: Tinggi ke
  Rendah" berhasil menyusun kartu produk mulai dari nominal harga paling
  mahal di kiri atas. \| \[ \] PASS \[ \] FAIL \|

| Uji Penanganan Pencarian Kosong \| Mencari kata kunci yang tidak ada
  di database tidak memicu error, melainkan menampilkan pesan "Produk
  Tidak Ditemukan". \| \[ \] PASS \[ \] FAIL \|

## D. DOKUMENTASI VALIDASI TANGKAPAN LAYAR (SCREENSHOT)

1.  Bukti Tampilan Baru Beranda Katalog & Pengurutan Harga
    (/?sort=termurah)

(Tempel di sini - Pastikan Banner Toko, Dropdown Sorting, dan deretan
kartu produk yang terurut dari harga termurah terlihat jelas)

2.  Bukti Hasil Pencarian Produk Spesifik (/?search=...)

(Tempel di sini - Pastikan kata kunci di kotak pencarian atas,
keterangan jumlah barang ditemukan, dan kartu produk hasilnya terlihat
jelas)

3.  Bukti Tampilan Saat Produk Tidak Ditemukan (Empty Search State)

(Tempel di sini - Tampilkan layar ketika mencari kata kunci acak yang
tidak terdaftar di database)

## E. JURNAL PEMECAHAN MASALAH ANALITIS (TROUBLESHOOTING)

**Studi Kasus Query Database & Protokol HTTP:**

Pada ProductController.php, kita menulis kode pencarian where('name',
'LIKE', '%' . \$keyword . '%'). Jelaskan mengapa kita harus menambahkan
tanda persen (%) di bagian depan dan belakang variabel \$keyword? Apa
yang akan terjadi pada hasil pencarian pembeli jika tanda % tersebut
dihapus oleh programmer?

Mengapa formulir pencarian di master.blade.php menggunakan method="GET",
sedangkan formulir Checkout di Pertemuan 7 menggunakan method="POST"?

**Jawab:**

......................................................................................................................................................

......................................................................................................................................................

Mengetahui / Mengesahkan

Guru Mata Pelajaran Pemrograman Web

( Sulthan Alawy Shihab, S.Kom )
