<?php
class OrderController
{
    /* ===================== PUBLIK ===================== */

    public function form(): void
    {
        $menus = Menu::available();

        // item awal: dari input sebelumnya (jika validasi gagal) atau dari tombol "Pesan" di daftar menu
        $initial = [];
        $oldIds = old('menu_id', []);
        $oldQty = old('jumlah', []);
        if (is_array($oldIds) && $oldIds) {
            foreach ($oldIds as $i => $id) $initial[] = ['id' => (int)$id, 'qty' => max(1, (int)($oldQty[$i] ?? 1))];
        } elseif (($pre = (int)($_GET['menu'] ?? 0)) > 0) {
            $initial[] = ['id' => $pre, 'qty' => 1];
        }

        render('order/form', [
            'title' => 'Form Pemesanan', 'active' => 'order',
            'menus' => array_map(fn($m) => ['id' => (int)$m['id_menu'], 'nama' => $m['nama_menu'], 'harga' => (int)$m['harga']], $menus),
            'initial' => $initial,
        ]);
    }

    public function store(): void
    {
        csrf_verify();
        $nama    = trim((string)($_POST['nama'] ?? ''));
        $telepon = trim((string)($_POST['telepon'] ?? ''));
        $alamat  = trim((string)($_POST['alamat'] ?? ''));
        $email   = trim((string)($_POST['email'] ?? ''));
        $ambil   = (string)($_POST['pengambilan'] ?? '');
        $bayar   = (string)($_POST['pembayaran'] ?? '');

        $errors = [];
        if (mb_strlen($nama) < 2 || mb_strlen($nama) > 100)  $errors[] = 'Nama pelanggan wajib diisi.';
        if (!preg_match('/^\+?[0-9\s-]{8,20}$/', $telepon))  $errors[] = 'Nomor telepon/WhatsApp tidak valid.';
        if (!isset(Order::PENGAMBILAN[$ambil]))              $errors[] = 'Pilih metode pengambilan.';
        if (!isset(Order::PEMBAYARAN[$bayar]))               $errors[] = 'Pilih metode pembayaran.';
        if ($ambil === 'antar' && $alamat === '')            $errors[] = 'Alamat wajib diisi untuk pengantaran.';
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Format email tidak valid.';

        // gabungkan item; harga SELALU diambil dari database, bukan dari browser
        $ids = $_POST['menu_id'] ?? [];
        $qty = $_POST['jumlah'] ?? [];
        $agg = [];
        if (is_array($ids) && is_array($qty)) {
            foreach ($ids as $i => $id) {
                $id = (int)$id; $q = (int)($qty[$i] ?? 0);
                if ($id > 0 && $q > 0) $agg[$id] = min(99, ($agg[$id] ?? 0) + $q);
            }
        }
        if (!$agg) $errors[] = 'Pilih minimal satu menu.';

        $lines = []; $total = 0;
        if ($agg) {
            $menus = Menu::findMany(array_keys($agg));
            foreach ($agg as $id => $q) {
                $m = $menus[$id] ?? null;
                if (!$m || $m['status'] !== 'tersedia') {
                    $errors[] = 'Ada menu yang sudah tidak tersedia: ' . ($m['nama_menu'] ?? "#$id") . '.';
                    continue;
                }
                $sub = (int)$m['harga'] * $q;
                $total += $sub;
                $lines[] = ['id_menu' => $id, 'jumlah' => $q, 'harga_satuan' => (int)$m['harga'], 'subtotal' => $sub];
            }
        }

        if ($errors) {
            set_old($_POST);
            flash('error', implode("\n", $errors));
            redirect('order');
        }

        $idPesanan = Order::createWithDetails([
            'nama_pelanggan' => $nama, 'telepon' => $telepon,
            'alamat' => $alamat !== '' ? $alamat : null, 'email' => $email !== '' ? $email : null,
            'metode_pengambilan' => $ambil, 'metode_pembayaran' => $bayar,
            'total' => $total, 'status' => 'baru',
        ], $lines);

        $_SESSION['last_order'] = $idPesanan;
        redirect('order/done');
    }

    public function done(): void
    {
        $id = (int)($_SESSION['last_order'] ?? 0);
        $order = $id ? Order::find($id) : null;
        if (!$order) redirect('order');
        render('order/done', [
            'title' => 'Pesanan Diterima', 'order' => $order, 'details' => OrderDetail::byOrder($id),
        ]);
    }

    /* ===================== ADMIN ===================== */

    public function adminIndex(): void
    {
        $status = (string)($_GET['status'] ?? '');
        $selected = isset($_GET['id']) ? Order::find((int)$_GET['id']) : null;
        render('admin/orders', [
            'title'    => 'Pesanan Masuk',
            'summary'  => Order::summary(),
            'orders'   => Order::list($status),
            'status'   => $status,
            'selected' => $selected,
            'details'  => $selected ? OrderDetail::byOrder((int)$selected['id_pesanan']) : [],
        ], 'admin/layout');
    }

    /** Admin hanya mengedit (tidak ada "tambah pesanan"). */
    public function adminUpdate(): void
    {
        csrf_verify();
        $id = (int)($_POST['id_pesanan'] ?? 0);
        $status = (string)($_POST['status'] ?? '');
        $bayar  = (string)($_POST['pembayaran'] ?? '');
        $ambil  = (string)($_POST['pengambilan'] ?? '');

        if (!Order::find($id)) { flash('error', 'Pesanan tidak ditemukan.'); redirect('admin/orders'); }
        if (!isset(Order::STATUS[$status]) || !isset(Order::PEMBAYARAN[$bayar]) || !isset(Order::PENGAMBILAN[$ambil])) {
            flash('error', 'Data yang dikirim tidak valid.');
            redirect('admin/orders', ['id' => $id]);
        }

        Order::updateByAdmin($id, [
            'status' => $status, 'metode_pembayaran' => $bayar, 'metode_pengambilan' => $ambil,
            'id_user' => $_SESSION['admin']['id'],
        ]);
        flash('success', "Pesanan #$id disimpan.");
        redirect('admin/orders', ['id' => $id]);
    }
}
