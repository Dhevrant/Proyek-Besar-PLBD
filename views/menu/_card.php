<?php /** Partial kartu menu. Variabel: $m (baris menu), $detail (bool) */ ?>
<div class="card menu-card">
  <?php if ($m['gambar']): ?>
    <img class="thumb" src="uploads/menu/<?= e($m['gambar']) ?>" alt="<?= e($m['nama_menu']) ?>" loading="lazy">
  <?php else: ?><div class="ph">foto</div><?php endif; ?>
  <h3><?= e($m['nama_menu']) ?></h3>
  <?php if (!empty($detail) && $m['deskripsi']): ?><div class="muted"><?= e($m['deskripsi']) ?></div><?php endif; ?>
  <div class="price"><?= rupiah($m['harga']) ?></div>
  <?php if (!empty($detail)): ?>
    <div class="<?= $m['status'] === 'tersedia' ? 'st-ok' : 'st-no' ?>">Status: <?= e(Menu::STATUS[$m['status']]) ?></div>
  <?php endif; ?>
  <div style="margin-top:.5rem">
  <?php if ($m['status'] === 'tersedia'): ?>
    <a class="btn btn-dark btn-block" href="<?= url('order', ['menu' => $m['id_menu']]) ?>"><?= !empty($detail) ? 'Pesan' : '+ Pesan' ?></a>
  <?php else: ?>
    <span class="btn btn-block off">Habis</span>
  <?php endif; ?>
  </div>
</div>
