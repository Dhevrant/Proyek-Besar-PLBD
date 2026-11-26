<?php
class MenuController
{
    /* ===================== PUBLIK ===================== */

    public function home(): void
    {
        render('home/index', [
            'title'    => 'Beranda',
            'active'   => 'home',
            'featured' => Menu::featured(4),
            'faqs'     => FaqFeedback::faqs(3),
        ]);
    }

    public function index(): void
    {
        $search   = trim((string)($_GET['q'] ?? ''));
        $kategori = (string)($_GET['kategori'] ?? '');
        $page     = (int)($_GET['page'] ?? 1);
        $data = Menu::paginate($search, $kategori, $page, 8);
        render('menu/index', $data + [
            'title' => 'Daftar Menu', 'active' => 'menu', 'search' => $search, 'kategori' => $kategori,
        ]);
    }

    /* ===================== ADMIN ===================== */

    public function adminIndex(): void
    {
        $edit = isset($_GET['edit']) ? Menu::find((int)$_GET['edit']) : null;
        render('admin/menu', [
            'title' => 'Kelola Menu', 'menus' => Menu::all(), 'edit' => $edit,
        ], 'admin/layout');
    }

    public function save(): void
    {
        csrf_verify();
        $id       = (int)($_POST['id_menu'] ?? 0);
        $nama     = trim((string)($_POST['nama_menu'] ?? ''));
        $kategori = (string)($_POST['kategori'] ?? '');
        $status   = (string)($_POST['status'] ?? 'tersedia');
        $deskripsi = trim((string)($_POST['deskripsi'] ?? ''));
        $hargaRaw = preg_replace('/[.\s]/', '', (string)($_POST['harga'] ?? ''));

        $existing = $id ? Menu::find($id) : null;
        if ($id && !$existing) { flash('error', 'Menu tidak ditemukan.'); redirect('admin/menu'); }

        $errors = [];
        if ($nama === '' || mb_strlen($nama) > 100)           $errors[] = 'Nama menu wajib diisi (maks. 100 karakter).';
        if (!in_array($kategori, Menu::KATEGORI, true))       $errors[] = 'Kategori tidak valid.';
        if (!isset(Menu::STATUS[$status]))                    $errors[] = 'Status tidak valid.';
        if (!ctype_digit($hargaRaw) || (int)$hargaRaw < 1 || (int)$hargaRaw > 10000000) {
            $errors[] = 'Harga wajib berupa angka (tanpa huruf).';
        }

        $file = $_FILES['gambar'] ?? null;
        $hasFile = $file && $file['error'] !== UPLOAD_ERR_NO_FILE;
        $newImage = null;
        if (!$existing && !$hasFile) {
            $errors[] = 'Gambar wajib diunggah.';
        } elseif ($hasFile && !$errors) {
            $newImage = $this->upload($file, $uploadError);
            if ($newImage === null) $errors[] = $uploadError;
        }

        if ($errors) {
            set_old($_POST);
            flash('error', implode("\n", $errors));
            redirect('admin/menu', $id ? ['edit' => $id] : []);
        }

        $data = [
            'nama_menu' => $nama, 'kategori' => $kategori, 'harga' => (int)$hargaRaw,
            'deskripsi' => $deskripsi !== '' ? $deskripsi : null, 'status' => $status,
        ];
        if ($newImage) $data['gambar'] = $newImage;

        if ($existing) {
            Menu::update($id, $data);
            if ($newImage && $existing['gambar']) $this->removeImage($existing['gambar']);
            flash('success', 'Menu berhasil diperbarui.');
        } else {
            Menu::create($data);
            flash('success', 'Menu berhasil ditambahkan dan otomatis tampil di halaman depan.');
        }
        redirect('admin/menu');
    }

    public function delete(): void
    {
        csrf_verify();
        $id = (int)($_POST['id_menu'] ?? 0);
        $menu = Menu::find($id);
        if (!$menu) { flash('error', 'Menu tidak ditemukan.'); redirect('admin/menu'); }

        try {
            Menu::delete($id);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // masih dipakai di detail_pesanan
                flash('error', 'Menu sudah pernah dipesan sehingga tidak bisa dihapus. Ubah statusnya menjadi "Habis".');
                redirect('admin/menu');
            }
            throw $e;
        }
        if ($menu['gambar']) $this->removeImage($menu['gambar']);
        flash('success', 'Menu dihapus.');
        redirect('admin/menu');
    }

    /* ===================== UPLOAD ===================== */

    private function upload(array $file, &$error): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) { $error = 'Gagal mengunggah gambar.'; return null; }
        if ($file['size'] > 2 * 1024 * 1024)  { $error = 'Ukuran gambar maksimal 2 MB.'; return null; }

        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $ext  = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? null;
        if (!$ext || @getimagesize($file['tmp_name']) === false) {
            $error = 'Format gambar harus JPG, PNG, atau WEBP.';
            return null;
        }

        $name = bin2hex(random_bytes(8)) . '.' . $ext;
        if (!move_uploaded_file($file['tmp_name'], BASE_PATH . '/uploads/menu/' . $name)) {
            $error = 'Gagal menyimpan gambar. Pastikan folder uploads/menu dapat ditulis.';
            return null;
        }
        return $name;
    }

    private function removeImage(string $name): void
    {
        $path = BASE_PATH . '/uploads/menu/' . basename($name);
        if (is_file($path)) @unlink($path);
    }
}
