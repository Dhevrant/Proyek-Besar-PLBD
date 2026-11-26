<div class="card" style="max-width:640px;margin:1rem auto">
  <h1>Pesanan diterima</h1>
  <p>Terima kasih, <strong><?= e($order['nama_pelanggan']) ?></strong>. Admin akan menghubungi Anda lewat WhatsApp.</p>
  <p>Nomor pesanan: <strong>#<?= (int)$order['id_pesanan'] ?></strong> · Status: <span class="pill"><?= e(Order::STATUS[$order['status']]) ?></span></p>
  <div class="table-wrap"><table>
    <tr><th>Menu</th><th>Jumlah</th><th>Subtotal</th></tr>
    <?php foreach ($details as $d): ?>
      <tr><td><?= e($d['nama_menu']) ?></td><td>× <?= (int)$d['jumlah'] ?></td><td><?= rupiah($d['subtotal']) ?></td></tr>
    <?php endforeach; ?>
    <tr><th colspan="2">Total harga</th><th><?= rupiah($order['total']) ?></th></tr>
  </table></div>
  <p class="muted">
    Pengambilan: <?= e(Order::PENGAMBILAN[$order['metode_pengambilan']]) ?> ·
    Pembayaran: <?= e(Order::PEMBAYARAN[$order['metode_pembayaran']]) ?>
  </p>
  <a class="btn btn-dark" href="<?= url() ?>">Kembali ke Beranda</a>
</div>
