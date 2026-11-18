# ASESMEN SUMATIF AKHIR SEMESTER GANJIL

TAHUN AJARAN 2026-2027

| Mata Pelajaran | : | Pemrograman Web |

| --- | --- | --- |

| Hari / Tanggal | : | 16 – 26 November 2026 |

| Kelas / Fase | : | XII RPL 1, XII RPL 2 / Fase F |

| Guru Bidang Studi | : | Sulthan Alawy Shihab, S.Kom., Gr. |

## LEMBAR KERJA PESERTA DIDIK (LKPD)

UJIAN PRAKTIK RILIS FINAL E-COMMERCE & SELLER CENTER BERBASIS LARAVEL

| Judul Proyek | : | Rilis Final (Production Ready) Platform E-Commerce & Seller Center |

| --- | --- | --- |

| Elemen / TP | : | Pemrograman Web (TP.A1) |

| Bentuk Penilaian | : | Praktik Tim (kelompok P1–P12) / Project Based Learning (PjBL), dengan uji lisan kode per individu |

| Alokasi Waktu | : | 11 hari (16–26 November 2026): tatap muka dan pengerjaan tim |

| Software | : | Laragon (Apache, MySQL, PHP, Composer), Laravel, Visual Studio Code, Google Chrome, Draw.io/Figma, OBS Studio atau perekam layar, Microsoft Excel, Google Drive, YouTube |

| Output | : | Aplikasi siap rilis (source code .zip + database .sql), Dokumen Rancangan (2 flowchart + ERD), Video Demo di YouTube, Jurnal Progres Tim (.xlsx), README.txt |

| KKTP | : | 80 |

| Batas Pengumpulan | : | Kamis, 26 November 2026 pukul 23.59 WIB |

## I. SKENARIO PROYEK (ROLEPLAY)

Kalian adalah tim Software House yang sejak Pertemuan 1 membangun aplikasi toko online untuk klien: rancangan UI/UX di Figma (P1–P3), katalog dan pencarian (P4–P6, P11), checkout dan E-Invoice (P7), Seller Center untuk pesanan dan produk (P8–P10), hingga login Admin (P12). Klien siap meluncurkan toko ke publik, tetapi menemukan lima masalah pada versi P12:

Pembeli belum punya akun, sehingga tidak ada halaman Pesanan Saya dan pembeli harus menghafal URL /berhasil/{id} untuk melihat status pesanannya.

Siapa pun yang mengetahui URL /berhasil/{id} dapat mengintip invoice (nama, nomor HP, alamat) milik pembeli lain.

Produk belum punya kategori dan stok. Label “Stok Tersedia” dan rating “★ 5.0” di katalog masih palsu (hardcode).

Form checkout belum divalidasi di server, sehingga jumlah beli bisa dimanipulasi lewat Inspect Element.

Kartu Total Omzet di Seller Center ikut menghitung pesanan Pending yang belum dibayar.

Tugas Tim: perbaiki kelima masalah tersebut dengan menambahkan akun dua peran (customer dan admin), penjaga akses AdminMiddleware, kategori dan stok otomatis, serta penyempurnaan Seller Center. Lengkapi dengan minimal 2 fitur inovasi, buktikan semuanya dalam Video Demo tanpa jeda, dan pertanggungjawabkan kodenya dalam uji lisan individu.

## II. KETENTUAN UMUM PROYEK

Semua ketentuan berikut wajib dipenuhi. Ketentuan yang tidak terpenuhi mengurangi nilai pada aspek terkait di rubrik.

| No | Ketentuan | Rincian |

| --- | --- | --- |

| 1 | Melanjutkan proyek P12 | Kode dasar adalah proyek e-commerce tim hasil P1–P12 (Laravel, Laragon, database ecommerce_db). Dilarang memulai dari template atau proyek tim lain. |

| 2 | Identitas toko tetap | Nama toko, sektor, logo, dan warna brand sesuai Project Brief (P1) dan Design Tokens (P3). |

| 3 | Kerja tim, tanggung jawab individu | Tim yang sama sejak P1 (Project Manager, UI/UX Designer, Backend Developer). Setiap anggota wajib memahami seluruh kode, bukan hanya bagiannya, karena uji lisan dilakukan per individu. |

| 4 | Dua peran akun | Pendaftar baru otomatis berperan customer. Akun admin hanya boleh dibuat lewat Seeder, tidak boleh lewat form Register. |

| 5 | Data asli | Minimal 9 produk asli sesuai tema, 4 kategori, dan stok di setiap produk. Tidak boleh ada Lorem Ipsum, rating palsu, atau label stok palsu. |

| 6 | Keamanan form | Semua form POST memakai @csrf, form upload memakai enctype="multipart/form-data", dan setiap input divalidasi di server ($request->validate). |

| 7 | Zero-Error | Alur utama bebas error 404/500/419. ID palsu menghasilkan 404, akses terlarang menghasilkan 403 atau redirect dengan pesan. |

| 8 | Tampilan | Master Layout konsisten (master.blade.php dan admin.blade.php), font Plus Jakarta Sans/Inter, rapi di layar HP dan desktop. |

| 9 | Video demo | Rekaman layar tanpa jeda dan tanpa potongan, minimal 720p, berisi 4 skenario berurutan (Modul 7), disarankan 8–15 menit. Setiap anggota tim bersuara menjelaskan bagiannya. Video final wajib diunggah ke YouTube oleh perwakilan kelompok. |

| 10 | Dikumpulkan per tim | Satu tim satu folder di Google Drive pengumpulan kelas. Nilai aspek E (video dan uji lisan) diberikan per individu. |

| 11 | Unggah ke YouTube | Perwakilan kelompok mengunggah video final ke akun YouTube-nya dengan visibilitas Publik atau Tidak Publik (Unlisted), bukan Privat. Video tidak boleh dihapus sampai nilai diumumkan. |

Contoh pembagian tugas tim (boleh disesuaikan, catat di Lampiran A):

Project Manager: flowchart, ERD, Jurnal Progres Tim, uji QA (Lampiran C), skenario dan perekaman video, README.

Backend Developer: migration, seeder, AdminMiddleware, validasi stok, query omzet bersih, cek kepemilikan invoice.

UI/UX Designer (Frontend): halaman Register, navbar dinamis, filter kategori, halaman Pesanan Saya, badge status, Empty State, tampilan responsive.

Ketentuan khusus: tim yang anggotanya berhalangan, laptopnya bermasalah, atau tidak ada anggota yang dapat mengunggah ke YouTube wajib melapor ke guru paling lambat Selasa, 17 November 2026. Guru akan menentukan cara pengganti.

## III. INSTRUKSI KERJA (7 MODUL WAJIB)

Kerjakan modul secara berurutan. Jangan merekam video (Modul 7) sebelum Modul 1–6 lulus uji QA di Lampiran C.

Modul 1 – Persiapan dan Perancangan (Backup, Flowchart, ERD)

Backup dahulu: export database lama lewat phpMyAdmin (.sql) dan salin folder proyek P12 sebagai cadangan.

Isi Lembar Perencanaan Tim (Lampiran A): pembagian tugas, daftar kategori, daftar produk, dan rencana fitur mandiri.

Gambar Flowchart 1 – Akses Seller Center di Draw.io/Figma. Wajib memuat dua Decision: “Sudah login?” (TIDAK → redirect /login) dan “Role = admin?” (TIDAK → tolak 403; YA → buka Seller Center).

Gambar Flowchart 2 – Checkout dan Pengurangan Stok. Wajib memuat Decision “Validasi lolos dan stok cukup?” (TIDAK → kembali ke form dengan pesan error; YA → simpan transaksi Pending, kurangi stok, tampilkan invoice).

Gambar ERD final: tabel users, products, transactions (ditambah tabel fitur mandiri jika ada) lengkap dengan Primary Key, Foreign Key, dan relasinya.

Modul 2 – Database dan Seeder

Buat migration baru (jangan mengubah migration lama): kolom role dan phone di users, kolom category dan stock di products, kolom user_id dan tracking_number di transactions. Kolom user_id dibuat nullable karena pesanan lama belum punya pemilik.

Tambahkan 'role' dan 'phone' ke $fillable pada app/Models/User.php.

Perbarui DatabaseSeeder: 1 akun admin, 2 akun customer uji (customer kedua sudah memiliki minimal 1 transaksi), minimal 4 kategori, dan stok untuk setiap produk.

Jalankan php artisan migrate lalu php artisan db:seed. Periksa hasilnya di phpMyAdmin.

Modul 3 – Autentikasi Multi-Role

Buat halaman Register customer. Validasi: nama wajib, email unik (unique:users), kata sandi minimal 8 karakter dan dikonfirmasi. Kata sandi disimpan dengan Hash::make(), peran otomatis customer, lalu pengguna langsung login.

Ubah proses Login P12: admin diarahkan ke /admin/transactions, customer kembali ke katalog atau ke halaman yang tadi dituju (redirect()->intended('/')).

Buat Navbar dinamis di layouts/master.blade.php:

Tamu: Search Bar, Katalog, tombol “Masuk / Daftar”.

Customer: “Halo, [Nama]”, Katalog, Pesanan Saya, tombol Keluar.

Admin: “Seller: [Nama]”, tombol Panel Seller Center, tombol Keluar.

Tombol Keluar wajib berupa form POST dengan @csrf, tidak boleh tag <a>.

Modul 4 – Middleware dan Hak Akses

Buat php artisan make:middleware AdminMiddleware: tolak (403) setiap pengguna yang belum login atau perannya bukan admin. Daftarkan alias admin di bootstrap/app.php.

Bungkus seluruh rute /admin/... dengan Route::middleware(['auth', 'admin']).

Pasang auth pada rute /checkout/{id}, /checkout/proses, /pesanan-saya, dan /berhasil/{id}. Tamu yang mengklik tombol beli otomatis diarahkan ke Login.

Tambahkan cek kepemilikan di fungsi success($id): jika invoice bukan milik pengguna yang login dan pengguna bukan admin, tampilkan 403.

Modul 5 – Fitur Pembeli: Kategori, Stok, Checkout, dan Pesanan Saya

Tampilkan kategori dan sisa stok asli di kartu katalog dan halaman detail. Hapus rating “★ 5.0” dan label “Stok Tersedia” palsu dari P11.

Tambahkan filter kategori di katalog yang tetap bisa digabung dengan pencarian dan pengurutan harga (contoh URL: /?search=jaket&category=Atasan&sort=termurah).

Di halaman checkout, nama penerima terisi otomatis dari akun (Auth::user()->name).

Validasi server: quantity minimal 1 dan tidak boleh melebihi stok. Pesan error tampil di bawah input (@error) dan isian lama tidak hilang (old()).

Setelah pesanan tersimpan dengan user_id pembeli dan status Pending, kurangi stok ($product->decrement('stock', $request->quantity)), lalu tampilkan invoice dengan pesan sukses.

Buat halaman Pesanan Saya (/pesanan-saya): hanya pesanan milik akun yang login, terbaru di atas, lengkap dengan nomor invoice, kurir, nomor resi, badge status, tombol lihat invoice, dan Empty State jika masih kosong.

Modul 6 – Penyempurnaan Seller Center dan UI/UX

Tampilkan 4 kartu statistik dari query database: Total Produk, Pesanan Pending, Pesanan Paid + Shipped, dan Total Omzet Bersih.

Total Omzet Bersih hanya menjumlahkan total_amount pesanan berstatus Paid atau Shipped. Pesanan Pending tidak boleh dihitung.

Tambahkan filter status pesanan (Semua, Pending, Paid, Shipped), isian nomor resi saat mengubah status, dan tombol hapus pesanan palsu/batal dengan konfirmasi.

Lengkapi form tambah dan edit produk dengan pilihan kategori dan input stok (divalidasi min:0).

Poles tampilan: tombol utama Primary/Success, tombol edit Info/Warning, tombol hapus Danger; badge Pending = kuning, Paid = biru, Shipped = hijau; flash message dan Empty State yang ramah; layout dua kolom tidak pecah di layar HP.

Modul 7 – Uji QA, Video Demo (YouTube), dan Jurnal Progres Tim

Jalankan php artisan optimize:clear dan php artisan route:list (pastikan rute admin memakai middleware auth dan admin). Lakukan semua uji di Matriks QA (Lampiran C) sampai seluruhnya lulus.

Rekam Video Demo tanpa jeda dengan 4 skenario berurutan:

Skenario 1 – Tamu: tunjukkan katalog, pencarian, filter kategori, dan pengurutan harga; perkecil jendela untuk membuktikan tampilan responsive; klik tombol beli dan ketik /admin/transactions (keduanya harus diarahkan ke Login).

Skenario 2 – Customer: daftar akun baru atas nama salah satu anggota tim; checkout dengan jumlah melebihi stok (muncul pesan error), lalu checkout yang benar; tunjukkan invoice Pending, stok berkurang, dan pesanan muncul di Pesanan Saya; ketik /admin/products dan /berhasil/{id} milik customer kedua (keduanya harus ditolak 403); Keluar.

Skenario 3 – Admin: login akun admin Seeder; tunjukkan omzet belum bertambah; tambah, edit (harga/stok), dan hapus 1 produk uji; filter Pending, ubah pesanan tadi menjadi Paid lalu Shipped dengan nomor resi; tunjukkan omzet bertambah; Keluar.

Skenario 4 – Verifikasi dan Inovasi: login lagi sebagai customer tadi, tunjukkan status hijau (Shipped) dan nomor resi; demonstrasikan fitur mandiri sambil menyebut nama fiturnya.

Perwakilan kelompok mengunggah video final ke YouTube (Publik atau Tidak Publik/Unlisted) dengan judul dan deskripsi sesuai ketentuan di Bagian VI, lalu menuliskan link-nya di README dan Lembar Identitas.

Isi Jurnal Progres Tim (Excel, format di Lampiran B) 1 baris setiap hari dari 16 sampai 26 November 2026, pada hari yang sama. Setiap baris mencantumkan anggota penanggung jawab (PIC), hasil, kendala dan solusi, serta bantuan AI/referensi yang dipakai.

## IV. MODUL PENGEMBANGAN MANDIRI (INOVASI TIM)

Pilih minimal 2 fitur dari tabel berikut, atau usulkan fitur lain yang relevan dan disetujui guru sebelum dikerjakan. Poin dijumlahkan, maksimal 10 poin. Fitur mandiri wajib dicatat di jurnal dan didemonstrasikan di akhir video.

| Tingkat | Pilihan Fitur | Poin |

| --- | --- | --- |

| Mudah | Cetak E-Invoice (window.print + @media print, tombol dan header tersembunyi saat dicetak)<br>Tombol chat WhatsApp otomatis (wa.me) antara pembeli dan penjual<br>Label “Stok Habis” dan tombol beli nonaktif jika stok 0<br>Halaman profil customer: ubah nama, nomor HP, alamat default, kata sandi | 3 poin / fitur |

| Sedang | Upload bukti transfer oleh pembeli dan verifikasi oleh admin<br>Kode voucher diskon saat checkout<br>Ekspor laporan penjualan ke PDF / Excel / CSV<br>Grafik penjualan (Chart.js) di dashboard admin<br>Pembatalan pesanan oleh pembeli selama Pending (stok kembali bertambah) | 5 poin / fitur |

| Sulit | Keranjang belanja multi-produk dengan sekali checkout<br>Ulasan dan rating bintang 1–5 oleh pembeli yang pesanannya sudah Shipped<br>Tabel categories dengan CRUD dan relasi category_id<br>Deployment publik atau tunneling (Ngrok / Laragon Share) sehingga toko bisa dibuka dari HP lain | 8 poin / fitur |

## V. ETIKA, KEAMANAN, DAN KEJUJURAN KODE (PANCAWALUYA: BENER)

Pelanggaran berat pada bagian ini membuat karya dinyatakan tidak sah dan wajib diulang.

Wajib dilakukan:

Mengerjakan kode bersama tim sendiri dan mampu menjelaskan setiap baris yang dikumpulkan.

Menyimpan kata sandi dengan Hash::make() dan memakai data uji fiktif (nama toko, alamat, nomor HP contoh).

Memakai foto produk milik sendiri, bebas royalti, atau berlisensi dengan atribusi.

Mencatat bantuan AI atau referensi (dokumentasi Laravel, forum, video) di Jurnal Progres Tim.

Dilarang:

Menyalin proyek tim lain, membeli source code, atau menyuruh orang lain mengerjakan.

Memotong atau menyambung video untuk menyembunyikan error.

Memakai data pribadi asli orang lain (alamat rumah, nomor HP, NIS/NISN) sebagai data uji.

Memakai logo atau nama marketplace asli (Tokopedia, Shopee, dsb.) sebagai identitas toko.

Batas penggunaan AI: AI boleh dipakai untuk menjelaskan error, mencari ide, dan membantu menulis kode. Kode hasil bantuan AI wajib dipahami. Saat uji lisan, guru dapat meminta siswa menjelaskan atau mengubah baris kode tertentu secara langsung.

## VI. HASIL AKHIR DAN PENGUMPULAN (DELIVERABLE)

Semua berkas dikumpulkan per tim di folder Google Drive pengumpulan yang dibagikan guru untuk setiap kelas, paling lambat Kamis, 26 November 2026 pukul 23.59 WIB. Setiap tim membuat satu subfolder bernama UPRAK_WEB_[Kelas]_[No. Tim]_[Nama Toko], lalu mengunggah semua berkas ke dalamnya.

| No | Berkas yang Dikumpulkan | Format | Contoh Nama File |

| --- | --- | --- | --- |

| 1 | Source code tanpa folder vendor dan node_modules | ZIP | UPRAK_WEB_XIIRPL1_TIM03_SOURCE.zip |

| 2 | Ekspor database MySQL | SQL | UPRAK_WEB_XIIRPL1_TIM03_DATABASE.sql |

| 3 | Dokumen Rancangan (Flowchart 1, Flowchart 2, ERD) | PDF | UPRAK_WEB_XIIRPL1_TIM03_RANCANGAN.pdf |

| 4 | Link Video Demo di YouTube (4 skenario, tanpa jeda), ditulis di README dan Lembar Identitas | Link YouTube | Judul video: UPRAK Web XII RPL 1 – Tim 03 – [Nama Toko] |

| 5 | Jurnal Progres Tim | Excel (.xlsx) | UPRAK_WEB_XIIRPL1_TIM03_JURNAL.xlsx |

| 6 | README: identitas toko dan tim, akun uji, daftar fitur mandiri (Lampiran F) | TXT | UPRAK_WEB_XIIRPL1_TIM03_README.txt |

Format nama file: UPRAK_WEB_[Kelas]_[No. Tim]_[Jenis Berkas]

Ketentuan unggah YouTube: diunggah oleh perwakilan kelompok; judul mengikuti contoh di tabel; deskripsi video memuat nama toko, nama dan peran anggota, kelas, serta daftar fitur mandiri; visibilitas Publik atau Tidak Publik (Unlisted). Pastikan link dapat diputar sebelum dikumpulkan.

Titik periksa (checkpoint): pada pertemuan Senin, 23 November 2026, guru memeriksa flowchart, ERD, migration, login multi-role, dan AdminMiddleware. Tim yang belum siap akan diberi bimbingan.

Uji lisan kode: dilaksanakan per individu pada pertemuan setelah batas pengumpulan, 5–10 menit per siswa, menggunakan laptop dan proyek tim.

Keterlambatan: nilai dikurangi 5 poin per hari, maksimal 3 hari (sampai 29 November 2026). Setelah itu, tim mengikuti program remedial.

## VII. KRITERIA PENILAIAN (RUBRIK UPRAK)

Nilai akhir maksimal 100. Aspek A–F dinilai dengan skor 1–4, sedangkan aspek G berasal dari poin fitur mandiri. Aspek E dinilai per individu; aspek lainnya dinilai per tim.

| Aspek Penilaian | Indikator Pencapaian (Kompeten jika...) | TP | Bobot |

| --- | --- | --- | --- |

| A. Perancangan Sistem | Flowchart 1 dan 2 memakai simbol standar dan logikanya sesuai alur AdminMiddleware serta validasi stok. ERD memuat seluruh tabel, PK, FK, dan relasinya. | TP.A1 | 10 |

| B. Keamanan (Multi-Role dan Middleware) | Register dan login berfungsi; admin hanya dari Seeder. Tamu diarahkan ke Login, customer ditolak di /admin, invoice orang lain ditolak. Navbar sesuai peran. Logout POST + @csrf. | TP.A1 | 20 |

| C. Fungsionalitas Inti dan Database | Pencarian, filter kategori, pengurutan, detail (404 untuk ID palsu), checkout tervalidasi, stok berkurang otomatis, Pesanan Saya, CRUD produk dengan foto, filter dan resi pesanan, serta omzet bersih (Paid/Shipped) berjalan tanpa error. | TP.A1 | 25 |

| D. UI/UX Standar Marketplace | Master Layout konsisten, card dan grid rapi, warna tombol dan badge status sesuai ketentuan, flash message dan Empty State ramah, responsive di HP. | TP.A1 | 10 |

| E. Video Demo dan Uji Lisan Kode (individu) | Video memuat 4 skenario secara runut tanpa potongan, siswa ikut menjelaskan, dan video dapat diputar dari link YouTube. Saat uji lisan, siswa mampu menjelaskan dan mengubah kode tim dengan benar. | TP.A1 | 15 |

| F. Jurnal Progres dan Kolaborasi Tim | Jurnal minimal 11 baris (16–26 November), diisi setiap hari dengan PIC, kendala, solusi, dan bukti. Pembagian tugas terlihat merata. | TP.A1 | 10 |

| G. Pengembangan Mandiri | Minimal 2 fitur berfungsi, terintegrasi, dan didemonstrasikan. Poin sesuai tingkat kesulitan, maksimal 10. | – | 10 |

| TOTAL |  |  | 100 |

Pedoman skor aspek A–F:

| Skor | Kategori | Kriteria |

| --- | --- | --- |

| 4 | Mahir | Semua indikator terpenuhi dengan sangat baik dan mandiri. |

| 3 | Cakap | Indikator terpenuhi, terdapat sedikit kekurangan kecil. |

| 2 | Berkembang | Sebagian indikator belum terpenuhi atau terdapat kesalahan cukup berarti. |

| 1 | Baru Memulai | Sebagian besar indikator belum terpenuhi. |

Pengolahan nilai:

Nilai Aspek = (Skor ÷ 4) × Bobot

Nilai Akhir Siswa = A + B + C + D + F + G (nilai tim) + E (nilai individu), maksimal 100

Contoh: skor aspek B = 3, maka nilai aspek B = (3 ÷ 4) × 20 = 15.

Ketentuan tambahan:

Akun admin dapat dibuat lewat form Register publik: skor maksimal aspek B adalah 2.

Pesanan Pending ikut terhitung sebagai omzet, atau stok tidak berkurang: skor maksimal aspek C adalah 2.

Video terpotong/disambung atau skenario tidak lengkap: skor maksimal aspek E adalah 2 untuk seluruh anggota tim.

Link YouTube tidak dapat diputar (Privat atau dihapus): aspek E belum dinilai sampai link diperbaiki, dan berlaku aturan keterlambatan.

Siswa tidak mampu menjelaskan kode timnya saat uji lisan: skor maksimal aspek E siswa tersebut adalah 2.

Jurnal diisi sekaligus di akhir (terlihat dari isi atau riwayat file): skor maksimal aspek F adalah 2.

Tindak lanjut: peserta didik dengan nilai akhir di bawah KKTP 80 mengikuti remedial berupa perbaikan aspek yang skornya di bawah 3 dan uji lisan ulang. Peserta didik dengan nilai 80 ke atas dapat mengikuti pengayaan, misalnya deployment toko secara publik.

## VIII. LEMBAR IDENTITAS PENGUMPULAN

Isi tabel ini (cukup oleh Project Manager), lalu simpan sebagai file UPRAK_WEB_[Kelas]_[No. Tim]_IDENTITAS (Word/PDF) di subfolder Google Drive tim.

| Data | Isian Tim |

| --- | --- |

| Nama toko / sektor |  |

| Kelas / No. tim |  |

| Project Manager |  |

| UI/UX Designer |  |

| Backend Developer |  |

| Link video YouTube |  |

| Pengunggah YouTube (nama anggota) |  |

| Akun admin (email / sandi) |  |

| Akun customer 1 dan 2 (email / sandi) |  |

| Fitur pengembangan mandiri |  |

| Metode pengerjaan | Tim (kelompok P1–P12) |

| Mengetahui,<br>Waka Urs. Kurikulum<br> <br> <br> <br>Amirul Hadid R., M.Pd.<br>NIG. 0170194006 | Cibinong, 16 November 2026<br> <br>Guru Mata Pelajaran,<br> <br> <br> <br>Sulthan Alawy Shihab, S.Kom., Gr.<br>NIG. 0250198079 |

| --- | --- |

Mengetahui,

Kepala SMK Plus Pelita Nusantara

Sri Mildawati, S.Pd., M.Pd.

NIG. 0250186083

## LAMPIRAN

## Lampiran A – Lembar Perencanaan Tim (diisi tim)

Nama toko: ............................................................   Kelas / No. Tim: ......................

Bagian 1: Pembagian Tugas

| Nama Anggota | Peran | Tugas Utama UPRAK (modul/fitur) |

| --- | --- | --- |

|  | Project Manager |  |

|  | UI/UX Designer |  |

|  | Backend Developer |  |

Bagian 2: Kategori dan Data Produk (minimal 4 kategori, 9 produk)

| Kategori 1: | Kategori 2: | Kategori 3: | Kategori 4: |

| --- | --- | --- | --- |

| No | Nama Produk | Kategori | Harga (Rp) | Stok |

| --- | --- | --- | --- | --- |

| 1 |  |  |  |  |

| 2 |  |  |  |  |

| 3 |  |  |  |  |

| 4 |  |  |  |  |

| 5 |  |  |  |  |

| 6 |  |  |  |  |

| 7 |  |  |  |  |

| 8 |  |  |  |  |

| 9 |  |  |  |  |

Bagian 3: Rencana Fitur Mandiri (minimal 2)

| Nama Fitur | Tingkat | PIC (Anggota) | Paraf Guru |

| --- | --- | --- | --- |

|  |  |  |  |

|  |  |  |  |

|  |  |  |  |

## Lampiran B – Format Jurnal Progres Tim (Excel)

Buat file Excel dengan satu sheet Jurnal Harian. Isi 1 baris setiap hari dari 16 sampai 26 November 2026 (11 baris). Hari tanpa pengerjaan tetap diisi “Tidak ada pengerjaan” beserta alasannya.

| Kolom | Isi yang Diharapkan | Contoh |

| --- | --- | --- |

| Hari, Tanggal | Tanggal kegiatan | Sabtu, 14/11/2026 |

| Modul | Modul 1–7 atau fitur mandiri | Modul 2 |

| Kegiatan | Apa yang dikerjakan tim hari itu | Membuat migration kolom role, category, stock, user_id |

| PIC | Anggota penanggung jawab | Rina (Backend) |

| Hasil | Hasil kerja hari itu | Tabel bertambah kolom, seeder admin + 2 customer berhasil |

| Kendala dan Solusi | Masalah yang muncul dan cara mengatasinya | Admin ikut ditolak 403; ternyata role belum masuk $fillable |

| Bantuan AI / Referensi | Prompt atau link yang dipakai | Dokumentasi Laravel: Middleware |

| Bukti | Nama file screenshot atau link | m2_phpmyadmin.png |

| Progres (%) | Kemajuan total proyek 0–100 | 30 |

## Lampiran C – Matriks Uji QA Sebelum Merekam Video

Project Manager mencentang setiap uji. Video baru boleh direkam jika semua uji lulus.

| No | Uji | Hasil yang Diharapkan | Lulus |

| --- | --- | --- | --- |

| 1 | Tamu klik tombol beli | Diarahkan ke halaman Login | [  ] |

| 2 | Tamu ketik /admin/transactions | Diarahkan ke halaman Login | [  ] |

| 3 | Register akun baru | Login otomatis, navbar “Halo, [Nama]”, peran customer | [  ] |

| 4 | Customer ketik /admin/products | Ditolak 403 / redirect dengan pesan merah | [  ] |

| 5 | Customer buka /berhasil/{id} milik customer lain | Ditolak 403 | [  ] |

| 6 | Ketik /detail/999 | Halaman 404 | [  ] |

| 7 | Checkout dengan jumlah > stok | Pesan error tampil, isian lama tetap ada | [  ] |

| 8 | Checkout valid | Invoice Pending tampil, stok berkurang sesuai jumlah | [  ] |

| 9 | Buka Pesanan Saya | Hanya pesanan milik akun yang login | [  ] |

| 10 | Login admin, lihat kartu omzet | Pesanan Pending tidak terhitung | [  ] |

| 11 | Ubah status menjadi Paid/Shipped + resi | Omzet bertambah, badge berubah warna | [  ] |

| 12 | Tambah, edit, hapus produk | Foto ter-upload, file lama terhapus, konfirmasi hapus muncul | [  ] |

| 13 | Pencarian + filter kategori + sort | Hasil sesuai, ada Empty State jika kosong | [  ] |

| 14 | Perkecil jendela browser | Tampilan tidak pecah di ukuran HP | [  ] |

| 15 | Klik Keluar (admin dan customer) | Sesi berakhir, /admin kembali terkunci | [  ] |

## Lampiran D – Jadwal Pengerjaan yang Disarankan

| Hari, Tanggal | Target Kegiatan |

| --- | --- |

| Senin, 16 November | Membaca pedoman, backup proyek P12, mengisi Lembar Perencanaan Tim. |

| Selasa, 17 November | Flowchart 1, Flowchart 2, dan ERD final (Modul 1). Batas lapor kendala anggota/laptop/YouTube. |

| Rabu, 18 November | Migration dan Seeder (Modul 2). |

| Kamis, 19 November | Register, login multi-role, navbar dinamis (Modul 3). |

| Jumat, 20 November | AdminMiddleware, proteksi rute, dan cek kepemilikan invoice (Modul 4). |

| Sabtu, 21 November | Kategori, stok, checkout tervalidasi (Modul 5). |

| Minggu, 22 November | Halaman Pesanan Saya; mulai kartu statistik dan omzet bersih (Modul 5–6). |

| Senin, 23 November | Checkpoint guru (rancangan, database, login, middleware). Filter status, resi, CRUD produk dengan stok (Modul 6). |

| Selasa, 24 November | Polesan UI/UX dan fitur mandiri pertama. |

| Rabu, 25 November | Fitur mandiri kedua, uji Matriks QA (Lampiran C), perbaikan bug. |

| Kamis, 26 November | Rekam video final dan unggah ke YouTube, ekspor .sql dan .zip, README, lengkapi jurnal, unggah ke Google Drive sebelum 23.59 WIB. |

## Lampiran E – Acuan Teknis (Database, Rute, dan Kode Kunci)

Struktur tabel akhir:

| Tabel | Kolom (minimal) |

| --- | --- |

| users | id, name, email, password, role (admin/customer, default customer), phone (nullable), timestamps |

| products | id, name, category, price, stock (default 10), description, image (nullable), timestamps |

| transactions | id, user_id (FK ke users, nullable), product_id, invoice_code, product_name, customer_name, customer_phone, customer_address, courier, quantity, shipping_cost, total_amount, status (Pending/Paid/Shipped), tracking_number (nullable), timestamps |

Relasi: User hasMany Transaction; Product hasMany Transaction; Transaction belongsTo User dan Product. Kolom product_name disimpan sebagai salinan agar riwayat pesanan tetap terbaca walaupun produknya dihapus.

Peta rute akhir:

| Hak Akses | Method | URL | Fungsi |

| --- | --- | --- | --- |

| Publik | GET | /, /detail/{id} | Katalog (search, filter, sort) dan detail |

| Tamu | GET/POST | /login, /register | Masuk dan daftar customer |

| Login (auth) | POST | /logout | Keluar |

| Customer (auth) | GET/POST | /checkout/{id}, /checkout/proses | Form dan proses checkout |

| Customer (auth) | GET | /pesanan-saya | Riwayat pesanan sendiri |

| Customer/Admin (auth) | GET | /berhasil/{id} | Invoice (cek kepemilikan) |

| Admin (auth + admin) | GET | /admin/transactions | Statistik, daftar, filter pesanan |

| Admin (auth + admin) | POST | /admin/transactions/{id}/status, .../{id}/delete | Ubah status + resi, hapus pesanan |

| Admin (auth + admin) | GET/POST | /admin/products/... | CRUD produk (P9–P10) |

Kode kunci:

| // app/Http/Middleware/AdminMiddleware.php (fungsi handle)<br>if (!auth()->check() || auth()->user()->role !== 'admin') {<br>    abort(403, 'Akses ditolak! Halaman ini khusus Admin Seller Center.');<br>}<br>return $next($request);<br> <br>// bootstrap/app.php<br>->withMiddleware(function (Middleware $middleware) {<br>    $middleware->alias(['admin' => \App\Http\Middleware\AdminMiddleware::class]);<br>}) |

| --- |

| // ProductController@storeTransaction<br>$product = Product::findOrFail($request->product_id);<br>$request->validate([<br>    'customer_name'    => 'required|string|max:100',<br>    'customer_phone'   => 'required|string|max:20',<br>    'customer_address' => 'required|string',<br>    'courier'          => 'required|in:JNE Reguler,J&T Express,SiCepat BEST',<br>    'quantity'         => 'required|integer|min:1|max:' . $product->stock,<br>], ['quantity.max' => 'Jumlah beli melebihi sisa stok (' . $product->stock . ' unit).']);<br>// ... hitung ongkir dan total seperti P7, simpan dengan user_id, lalu:<br>$product->decrement('stock', $request->quantity);<br> <br>// ProductController@success (cek kepemilikan)<br>if ($transaction->user_id != auth()->id() && auth()->user()->role !== 'admin') {<br>    abort(403, 'Anda tidak berhak melihat invoice ini.');<br>}<br> <br>// AdminController@transactions (omzet bersih)<br>$totalRevenue = Transaction::whereIn('status', ['Paid', 'Shipped'])->sum('total_amount'); |

| --- |

## Lampiran F – Template README.txt

| NAMA TOKO   : [Nama Toko] – [Sektor]<br>KELAS / TIM : [XII RPL 1 / Tim 03]<br>ANGGOTA     : [Nama] (Project Manager)<br>              [Nama] (UI/UX Designer)<br>              [Nama] (Backend Developer)<br> <br>CARA MENJALANKAN<br>1. Import [nama file].sql ke database ecommerce_db<br>2. composer install, lalu php artisan serve<br> <br>AKUN UJI<br>Admin      : admin@[toko].com / [sandi]<br>Customer 1 : [email] / [sandi]<br>Customer 2 : [email] / [sandi]<br> <br>VIDEO DEMO  : [link YouTube] (diunggah oleh [nama anggota])<br> <br>FITUR MANDIRI<br>1. [Nama fitur] – [tingkat] – [cara mencoba]<br>2. [Nama fitur] – [tingkat] – [cara mencoba] |

| --- |

## Lampiran G – Kesalahan Umum yang Perlu Diwaspadai

Tombol Seller Center hanya disembunyikan di navbar, tetapi AdminMiddleware tidak dipasang di rute, sehingga customer tetap bisa masuk lewat URL.

role belum masuk $fillable model User, sehingga admin dari Seeder tersimpan sebagai customer dan ikut ditolak 403.

Alias admin belum didaftarkan di bootstrap/app.php (error Target class [admin] does not exist).

Lupa cek kepemilikan di fungsi success($id), sehingga invoice orang lain masih bisa dibuka.

Stok dikurangi sebelum validasi lolos, atau tidak dikurangi sama sekali.

Pesanan Pending masih dihitung ke Total Omzet Bersih.

Menjalankan php artisan migrate:fresh tanpa backup, sehingga produk dan pesanan P7–P12 hilang.

Lupa @csrf pada form Keluar (error 419) atau lupa enctype pada form upload.

Menulis perintah tanpa awalan php (misalnya artisan db:seed); yang benar php artisan db:seed.

Video dipotong untuk menutupi error, atau Jurnal Progres Tim diisi sekaligus di hari terakhir.

Video YouTube diatur Privat, sehingga guru tidak dapat memutarnya; atau link yang dikirim salah.

Berkas diunggah langsung ke folder kelas tanpa subfolder tim, atau nama subfolder tidak sesuai format.