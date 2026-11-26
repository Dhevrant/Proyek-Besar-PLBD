<?php
// Semua konfigurasi di satu file: koneksi database + data umum situs.
return [
    'database' => [
        'host'     => 'localhost',
        'port'     => 3306,
        'dbname'   => 'preorder_sari_bulan',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
    ],
    // Data situs: ganti sesuai data asli RM Sari Bulan.
    'app' => [
        'nama'       => 'RM Sari Bulan',
        'kota'       => 'Balikpapan',
        'alamat'     => '[Alamat], Balikpapan',
        'jam_buka'   => '[JAM BUKA]',
        'wa'         => '6281234567890',   // nomor WhatsApp outlet (format 62...)
        'instagram'  => 'https://instagram.com/',
        'maps_embed' => '',                // isi dengan URL src iframe Google Maps (embed)
        'tentang'    => 'RM Sari Bulan Balikpapan menyajikan masakan Padang dengan cita rasa khas. Ceritakan sejak kapan berdiri dan ciri khas masakan di sini.',
        'debug'      => false,
    ],
];
