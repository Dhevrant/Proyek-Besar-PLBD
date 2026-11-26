<h1>Pesanan Masuk</h1>

<div class="grid g4">
  <div class="card stat">Pesanan baru<b><?= $summary['baru'] ?></b></div>
  <div class="card stat">Sedang disiapkan<b><?= $summary['disiapkan'] ?></b></div>
  <div class="card stat">Siap diambil/dikirim<b><?= $summary['siap'] ?></b></div>
  <div class="card stat">Selesai hari ini<b><?= $summary['selesai'] ?></b></div>
</div>

<div class="card" style="margin-top:1rem">
  <div class="row-between">
    <h2>Daftar Pesanan</h2>
    <div class="filters" style="margin:0">
      <a class="pill <?= $status === '' ? 'on' : '' ?>" href="<?= url('admin/orders') ?>">Semua</a>
      <?php foreach (Order::STATUS as $k => $v): ?>
        <a class="pill <?= $status === $k ? 'on' : '' ?>" href="<?= url('admin/orders', ['status' => $k]) ?>"><?= e($v) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="table-wrap"><table>
    <tr><th>No.</th><th>Nama</th><th>Telepon</th><th>Total</th><th>Pengambilan</th><th>Status</th><th></th></tr>
    <?php if (!$orders): ?><tr><td colspan="7" class="muted">Belum ada pesanan.</td></tr><?php endif; ?>
    <?php foreach ($orders as $o): ?>
      <tr>
        <td>#<?= (int)$o['id_pesanan'] ?></td>
        <td><?= e($o['nama_pelanggan']) ?></td>
        <td><?= e($o['telepon']) ?></td>
        <td><?= rupiah($o['total']) ?></td>
        <td><?= $o['metode_pengambilan'] === 'antar' ? 'Diantar' : 'Diambil' ?></td>
        <td><span class="pill"><?= e(Order::STATUS[$o['status']]) ?></span></td>
        <td><a class="btn btn-sm <?= ($selected && $selected['id_pesanan'] == $o['id_pesanan']) ? 'btn-dark' : '' ?>"
               href="<?= url('admin/orders', array_filter(['id' => $o['id_pesanan'], 'status' => $status])) ?>#detail">Detail</a></td>
      </tr>
    <?php endforeach; ?>
  </table></div>
  <p class="muted">Tidak ada tombol "Tambah pesanan": admin hanya mengedit, pesanan dibuat pelanggan lewat form.</p>
</div>

<?php if ($selected): ?>
<div class="card" style="margin-top:1rem" id="detail">
  <h2>Detail Pesanan #<?= (int)$selected['id_pesanan'] ?></h2>
  <div class="grid g2">
    <div>
      <p><strong>Nama:</strong> <?= e($selected['nama_pelanggan']) ?><br>
         <strong>Telepon:</strong> <?= e($selected['telepon']) ?><br>
         <strong>Alamat:</strong> <?= e($selected['alamat'] ?: '-') ?><br>
         <strong>Email:</strong> <?= e($selected['email'] ?: '-') ?><br>
         <strong>Dipesan:</strong> <?= e(tgl($selected['tanggal'])) ?></p>
      <hr style="border:0;border-top:1px dashed #aaa">
      <?php foreach ($details as $d): ?>
        <div class="row-between"><span><?= e($d['nama_menu']) ?> × <?= (int)$d['jumlah'] ?></span><span><?= rupiah($d['subtotal']) ?></span></div>
      <?php endforeach; ?>
      <div class="total"><span>Total harga</span><span><?= rupiah($selected['total']) ?></span></div>
    </div>

    <form method="post" action="<?= url('admin/orders/update') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id_pesanan" value="<?= (int)$selected['id_pesanan'] ?>">
      <strong>Ubah data (edit)</strong>
      <label for="status">Status</label>
      <select id="status" name="status">
        <?php foreach (Order::STATUS as $k => $v): ?>
          <option value="<?= $k ?>" <?= $selected['status'] === $k ? 'selected' : '' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select>
      <label for="pembayaran">Metode pembayaran</label>
      <select id="pembayaran" name="pembayaran">
        <?php foreach (Order::PEMBAYARAN as $k => $v): ?>
          <option value="<?= $k ?>" <?= $selected['metode_pembayaran'] === $k ? 'selected' : '' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select>
      <label for="pengambilan">Metode pengambilan</label>
      <select id="pengambilan" name="pengambilan">
        <?php foreach (Order::PENGAMBILAN as $k => $v): ?>
          <option value="<?= $k ?>" <?= $selected['metode_pengambilan'] === $k ? 'selected' : '' ?>><?= e($v) ?></option>
        <?php endforeach; ?>
      </select>
      <p>
        <button class="btn btn-dark" type="submit">Simpan</button>
        <a class="btn" target="_blank" rel="noopener"
           href="<?= e(wa_link($selected['telepon'], 'Halo ' . $selected['nama_pelanggan'] . ', pesanan Anda #' . $selected['id_pesanan'] . ' di ' . app('nama') . ' berstatus: ' . Order::STATUS[$selected['status']] . '.')) ?>">Hubungi via WhatsApp</a>
      </p>
      <p class="muted">Pengganti notifikasi: admin kabari pelanggan manual.</p>
    </form>
  </div>
</div>
<?php endif; ?>
