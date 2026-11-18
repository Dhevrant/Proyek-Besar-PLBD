# Proyek Besar PLBD
Ini adalah Proyek besar

# BAB I — PENDAHULUAN

## Judul

Judul yang digunakan adalah Perancangan Basis Data Sistem Pemesanan Pre-Order Berbasis Web pada RM Sari Bulan Masakan Padang. 

Makna judul tersebut: 

- **Aplikasi yang dibangun:** sistem pemesanan *pre-order* berbasis web. Pelanggan memilih menu dan jumlah dari jauh, lalu mengambil pesanan yang sudah disiapkan saat tiba. Basis data dirancang sebagai pondasinya untuk menyimpan menu, pesanan, rincian pesanan, jadwal pengambilan, dan pembayaran.

- **Pengguna sasaran:** pemilik atau pengelola RM Sari Bulan dan pelanggan, terutama yang memiliki waktu terbatas.

- **Masalah yang diselesaikan:** waktu tunggu pelanggan saat memilih lauk dan menunggu penyajian. Sistem ini menjadi peluang peningkatan layanan, bukan solusi atas masalah pencatatan.

## Latar Belakang

Perkembangan teknologi mengubah kebiasaan masyarakat dalam memesan makanan. Layanan seperti GoFood dari Gojek membuat pelanggan terbiasa memilih menu dan memesan melalui aplikasi; sebuah riset yang dilaporkan pada 2019 mencatat GoFood menguasai sekitar 75 persen pasar layanan pesan-antar makanan di Indonesia [1]. Layanan tersebut juga menyediakan opsi pengambilan sendiri (*pickup*) [2]. Di sisi lain, pengembangan sistem pemesanan berbasis web untuk usaha kuliner skala kecil telah banyak dilakukan, antara lain pada rumah makan Padang [3], UMKM makanan [4], dan katering berbasis *pre-order* [5]. Sistem berbasis web dipilih karena memungkinkan pelanggan bertransaksi tanpa harus berkunjung langsung ke lokasi usaha [5].

RM Sari Bulan merupakan rumah makan Padang di Balikpapan. Berdasarkan wawancara dan observasi pada 15 Oktober 2026, menu diupayakan selalu tersedia dan segera diisi ulang bila habis. Pembayaran dapat dilakukan secara tunai atau QRIS, dan nota diberikan bila pelanggan memintanya. Pemilik tidak menyampaikan kendala operasional maupun kendala pencatatan.

Meskipun operasional saat ini berjalan lancar dan jumlah pelanggan yang datang tidak terlalu banyak sehingga antrean jarang terjadi, kondisi tersebut justru membuka peluang peningkatan layanan. Pelanggan yang memiliki waktu istirahat terbatas tetap harus memilih lauk dan menunggu penyajian di lokasi. Dengan sistem *pre-order*, pelanggan dapat memesan dari jauh dan langsung mengambil pesanan saat tiba. Sistem ini juga dapat membantu RM Sari Bulan menjangkau pelanggan yang belum sempat datang langsung, serta lebih siap menghadapi lonjakan pesanan pada jam tertentu, misalnya jam makan siang.

Oleh karena itu, dirancang basis data untuk mendukung sistem web *pre-order* yang menyimpan menu, pesanan, rincian pesanan, jadwal pengambilan, dan metode pembayaran (tunai/QRIS) secara terpusat. Aplikasi dibangun dengan PHP berbasis pemrograman berorientasi objek (OOP) dan arsitektur *Model-View-Controller* (MVC). OOP membagi kode ke dalam kelas yang dapat digunakan ulang. MVC memisahkan pengelolaan data (Model), tampilan (View), dan alur logika (Controller), sehingga kode lebih rapi, mudah dipelihara, dan mudah dikembangkan oleh anggota kelompok secara paralel.

## Tujuan Pembuatan Aplikasi

- Membangun aplikasi pre-order berbasis web yang memungkinkan pelanggan memesan menu dari jauh (diuji: pesanan dapat dibuat, dilihat, diubah, dan dihapus melalui CRUD).

- Menyediakan pilihan jadwal pengambilan agar pesanan siap saat pelanggan tiba (diuji: jadwal tersimpan dan tampil pada pesanan).

- Mempermudah pelanggan melihat menu dan harga sebelum memesan sehingga pesanan dapat disiapkan sebelum pelanggan tiba (diuji: daftar menu tampil sesuai data).

- Mempermudah pemilik melihat daftar pesanan masuk beserta status pembayarannya (diuji: data tampil sesuai).

- Menyediakan basis data relasional yang konsisten untuk menu, pesanan, rincian pesanan, dan pembayaran (diuji: relasi dan *foreign key* berfungsi).

- Menerapkan validasi data pada setiap input (diuji: input salah ditolak).

- Menerapkan arsitektur MVC dan konsep OOP agar kode mudah dikelola dan dikembangkan (diuji: struktur kode dan fungsi berjalan).

Tuliskan tujuan pembuatan aplikasi dalam bentuk poin (gunakan fitur bullet atau numbering pada dokumen). Setiap tujuan harus menjawab permasalahan yang disebutkan di Latar Belakang dan dapat diukur atau dibuktikan melalui hasil pengujian di Bab III. Awali setiap poin dengan kata kerja, misalnya “Membangun”, “Menyediakan”, “Mempermudah”, atau “Menerapkan”. Contoh: Membangun aplikasi yang dapat mencatat data peminjaman alat secara terpusat; Menerapkan arsitektur MVC dan konsep OOP agar kode mudah dikelola dan dikembangkan.

# BAB II — METODE PENELITIAN

## Diagram Alir Penelitian

Metode yang digunakan adalah **Extreme Programming (XP)** dengan tahapan *Planning*, *Design*, *Coding (Development)*, dan *Testing*. Tahapan diulang dalam iterasi pendek sampai fitur sesuai kebutuhan.

(gambar)

Penjelasan tahapannya:

- **Planning.** Mengumpulkan kebutuhan melalui wawancara dan observasi di RM Sari Bulan, lalu menentukan fitur utama: daftar menu, pemesanan, jadwal pengambilan, dan pembayaran tunai/QRIS. Pada tahap ini juga dibagi tugas kelompok dan disusun jadwal.

- **Design.** Merancang basis data (ERD dan relasi antar tabel), diagram kelas, dan struktur MVC. Rancangan dibuat sederhana sesuai kebutuhan saat ini dan boleh disempurnakan pada iterasi berikutnya.

- **Coding (Development).** Mengimplementasikan fitur secara bertahap dengan PHP OOP: CRUD memakai PDO, Query Builder, dan validasi data.

- **Testing.** Menguji setiap fitur yang selesai dengan pengujian *black box* untuk memastikan fungsi berjalan sesuai tujuan di subbab 1.3. Hasilnya akan dibahas di Bab III. Jika ada kekurangan atau masukan pemilik, proses kembali ke Planning.

Alasan memilih metode:

- Proyek berskala kecil dengan waktu terbatas, sehingga siklus pendek memungkinkan fitur dibangun dan diuji bertahap.

- Kebutuhan dapat berubah setelah asistensi atau masukan pemilik, dan XP menerima perubahan di tengah proses.

- Kesalahan terdeteksi lebih awal karena pengujian dilakukan setiap iterasi.

- Cocok untuk tim kecil karena menekankan komunikasi intensif dan pembagian tugas yang jelas.

Jelaskan metode pengembangan perangkat lunak yang digunakan, misalnya Extreme Programming (XP) atau salah satu model SDLC seperti Waterfall. Sertakan gambar diagram alir (flowchart) tahapan metode tersebut, beri nomor dan keterangan gambar (contoh: Gambar 2.1 Diagram Alir Penelitian), lalu jelaskan setiap tahapannya secara singkat. Untuk XP, tahapan umumnya terdiri dari Planning, Design, Coding (Development), dan Testing. Jelaskan juga alasan memilih metode tersebut untuk proyek ini.

## *Planning*

Jelaskan perencanaan kalian dari tahap awal proyek, meliputi: identifikasi kebutuhan pengguna, daftar kebutuhan fungsional (fitur yang harus ada, misalnya login, kelola data, laporan) dan kebutuhan non-fungsional (keamanan, kemudahan penggunaan, kinerja), aktor atau peran pengguna beserta hak aksesnya, serta perangkat lunak dan perangkat keras yang digunakan (versi PHP, web server, DBMS, text editor). Jika menggunakan XP, tuliskan user story untuk setiap fitur. Cantumkan juga pembagian tugas antaranggota kelompok dan jadwal pengerjaan, boleh dalam bentuk tabel.

## Design

Jelaskan rancangan sistem yang dibuat sebelum masuk ke tahap pengkodean. Bagian ini berisi gambaran umum rancangan basis data dan struktur kelas program yang dirinci pada subbab berikut. Bila ada, tambahkan rancangan antarmuka (mockup atau wireframe) halaman-halaman utama aplikasi.

### Entity Relationship Diagram

Tampilkan Entity Relationship Diagram (ERD) dari basis data aplikasi lengkap dengan nomor dan keterangan gambar. Jelaskan setiap entitas (tabel) beserta atribut, primary key, dan foreign key, kemudian jelaskan relasi antarentitas dan kardinalitasnya (one-to-one, one-to-many, atau many-to-many). Pastikan ERD sesuai dengan tabel yang benar-benar dibuat di database aplikasi.

### Class Diagram

Tampilkan Class Diagram yang menggambarkan kelas-kelas dalam aplikasi, terutama kelas Model, Controller, dan kelas pendukung seperti kelas koneksi database atau Query Builder. Untuk setiap kelas, cantumkan atribut dan method beserta visibilitasnya (public, private, protected). Jelaskan hubungan antarkelas, misalnya pewarisan (inheritance) dari kelas induk seperti BaseModel atau BaseController, asosiasi, atau dependensi.

## Development

Jelaskan proses pengkodean aplikasi berdasarkan rancangan yang telah dibuat. Uraikan urutan pengerjaan (misalnya membuat struktur folder, koneksi database, model, controller, lalu view), alat bantu yang digunakan (text editor, Git/GitHub untuk version control, XAMPP/Laragon), serta kendala yang ditemui selama pengembangan dan cara mengatasinya. Pembahasan rinci hasil kode ditulis di Bab III.
