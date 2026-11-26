-- =====================================================
-- Database Pre-Order RM Sari Bulan Balikpapan
-- 5 tabel: users, menu, pesanan, detail_pesanan, faq_feedback
-- Import lewat phpMyAdmin atau: mysql -u root -p < database.sql
-- =====================================================
CREATE DATABASE IF NOT EXISTS preorder_sari_bulan
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE preorder_sari_bulan;

DROP TABLE IF EXISTS detail_pesanan;
DROP TABLE IF EXISTS pesanan;
DROP TABLE IF EXISTS faq_feedback;
DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS users;

-- 1. USERS: hanya admin (pelanggan tidak punya akun)
CREATE TABLE users (
  id_user    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama       VARCHAR(100) NOT NULL,
  email      VARCHAR(100) NOT NULL,
  telepon    VARCHAR(20)  NOT NULL,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('admin') NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_user),
  UNIQUE KEY uq_users_email (email),
  UNIQUE KEY uq_users_telepon (telepon)
) ENGINE=InnoDB;

-- 2. MENU
CREATE TABLE menu (
  id_menu    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nama_menu  VARCHAR(100) NOT NULL,
  kategori   ENUM('Lauk','Sayur','Minuman','Paket') NOT NULL DEFAULT 'Lauk',
  harga      INT UNSIGNED NOT NULL,
  deskripsi  TEXT NULL,
  gambar     VARCHAR(255) NULL,
  status     ENUM('tersedia','habis') NOT NULL DEFAULT 'tersedia',  -- status_kelengkapan di ERD
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_menu),
  KEY idx_menu_kategori (kategori),
  KEY idx_menu_status (status)
) ENGINE=InnoDB;

-- 3. PESANAN (TRANSAKSI di ERD). id_user = admin yang terakhir mengubah pesanan (boleh NULL)
CREATE TABLE pesanan (
  id_pesanan        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_user           INT UNSIGNED NULL,
  nama_pelanggan    VARCHAR(100) NOT NULL,
  telepon           VARCHAR(20)  NOT NULL,
  alamat            TEXT NULL,
  email             VARCHAR(100) NULL,
  metode_pengambilan ENUM('ambil','antar') NOT NULL DEFAULT 'ambil',
  metode_pembayaran  ENUM('tunai','qris')  NOT NULL DEFAULT 'tunai',
  total             INT UNSIGNED NOT NULL DEFAULT 0,
  status            ENUM('baru','disiapkan','siap','dikirim','selesai') NOT NULL DEFAULT 'baru',
  tanggal           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_pesanan),
  KEY idx_pesanan_status (status),
  CONSTRAINT fk_pesanan_user FOREIGN KEY (id_user) REFERENCES users(id_user)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 4. DETAIL_PESANAN (DETAIL_TRANSAKSI di ERD)
CREATE TABLE detail_pesanan (
  id_detail    INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_pesanan   INT UNSIGNED NOT NULL,
  id_menu      INT UNSIGNED NOT NULL,
  jumlah       SMALLINT UNSIGNED NOT NULL,
  harga_satuan INT UNSIGNED NOT NULL,   -- harga saat dipesan (arsip)
  subtotal     INT UNSIGNED NOT NULL,
  PRIMARY KEY (id_detail),
  KEY idx_detail_pesanan (id_pesanan),
  KEY idx_detail_menu (id_menu),
  CONSTRAINT fk_detail_pesanan FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_detail_menu FOREIGN KEY (id_menu) REFERENCES menu(id_menu)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 5. FAQ_FEEDBACK: tipe 'faq' (dibuat admin) dan 'kritik' (dikirim pengunjung)
--    faq   : judul = pertanyaan, isi = jawaban, id_user = admin pembuat
--    kritik: judul = NULL, isi = isi masukan, nama_pengirim = nama/anonim, id_user = NULL
CREATE TABLE faq_feedback (
  id_faq_feedback INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_user         INT UNSIGNED NULL,
  tipe            ENUM('faq','kritik') NOT NULL,
  judul           VARCHAR(255) NULL,
  isi             TEXT NOT NULL,
  nama_pengirim   VARCHAR(100) NULL,
  created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_faq_feedback),
  KEY idx_ff_tipe (tipe),
  CONSTRAINT fk_ff_user FOREIGN KEY (id_user) REFERENCES users(id_user)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ===================== DATA AWAL =====================
-- Login admin: admin@saribulan.com / admin123  (segera ganti setelah login pertama)
INSERT INTO users (nama, email, telepon, password) VALUES
('Admin', 'admin@saribulan.com', '081234567890',
 'admin1234');

-- Diisi dari urutan terbalik agar daftar (urut id terbaru) tampil sama seperti sketsa. Harga contoh, silakan ubah.
INSERT INTO menu (nama_menu, kategori, harga, deskripsi, status) VALUES
('Nasi Putih',    'Lauk',    5000,  'Nasi putih hangat.', 'tersedia'),
('Es Teh',        'Minuman', 5000,  'Es teh manis segar.', 'habis'),
('Daun Singkong', 'Sayur',   8000,  'Daun singkong rebus dengan bumbu gulai.', 'tersedia'),
('Telur Balado',  'Lauk',    9000,  'Telur rebus dengan sambal balado.', 'tersedia'),
('Sate Padang',   'Lauk',    25000, 'Sate daging dengan kuah kental khas Padang.', 'tersedia'),
('Gulai Ikan',    'Lauk',    22000, 'Ikan dimasak dengan kuah gulai kuning.', 'tersedia'),
('Ayam Pop',      'Lauk',    20000, 'Ayam rebus goreng sebentar dengan sambal.', 'tersedia'),
('Rendang Daging','Lauk',    28000, 'Daging sapi dimasak lama dengan santan dan rempah.', 'tersedia');

INSERT INTO faq_feedback (id_user, tipe, judul, isi) VALUES
(1, 'faq', 'Bagaimana cara memesan?', 'Pilih menu, isi form pemesanan (tanpa daftar akun), lalu kirim. Admin akan menghubungi lewat WhatsApp.'),
(1, 'faq', 'Berapa lama pesanan disiapkan?', 'Waktu persiapan akan dikonfirmasi admin lewat WhatsApp setelah pesanan diterima.'),
(1, 'faq', 'Apakah bisa diantar?', 'Bisa. Pilih metode "Diantar ke alamat" dan isi alamat lengkap pada form pemesanan.'),
(1, 'faq', 'Metode pembayaran apa saja?', 'Tunai atau QRIS.');