<!-- Banner -->
<section class="hero" id="hero">
  <?php foreach ([
    ['Pesan dulu, ambil tanpa antre', 'Pilih lauk dari mana saja, ambil di tempat atau diantar'],
    ['Masakan Padang khas Balikpapan', 'Rendang, ayam pop, gulai ikan, dan sate Padang'],
    ['Tanpa daftar akun', 'Cukup isi form pemesanan, admin akan menghubungi lewat WhatsApp'],
    ['Bayar tunai atau QRIS', 'Pilih metode yang paling nyaman untuk Anda'],
  ] as $i => [$h, $p]): ?>
    <div class="slide <?= $i === 0 ? 'on' : '' ?>">
      <h1><?= e($h) ?></h1><p><?= e($p) ?></p>
      <div><a class="btn btn-dark" href="<?= url('order') ?>">Pesan Sekarang</a> <a class="btn" href="<?= url('menu') ?>">Lihat Menu</a></div>
    </div>
  <?php endforeach; ?>
  <div class="dots"><i class="dot on"></i><i class="dot"></i><i class="dot"></i><i class="dot"></i></div>
</section>

<!-- Cara pesan -->
<section class="section">
  <h2>Cara Pesan</h2>
  <div class="grid g4">
    <div class="card"><strong>1. Lihat menu</strong><br>Cek menu, harga, dan statusnya</div>
    <div class="card"><strong>2. Isi form pesan</strong><br>Nama, no. telepon, alamat, menu &amp; jumlah (tanpa daftar akun)</div>
    <div class="card"><strong>3. Dikonfirmasi admin</strong><br>Admin menghubungi lewat WhatsApp saat pesanan siap</div>
    <div class="card"><strong>4. Ambil / diantar</strong><br>Ambil sendiri di outlet atau diantar</div>
  </div>
</section>

<!-- Menu unggulan -->
<section class="section">
  <div class="row-between"><h2>Menu Unggulan</h2><a class="btn" href="<?= url('menu') ?>">Lihat Semua</a></div>
  <?php if (!$featured): ?>
    <p class="muted">Belum ada menu.</p>
  <?php else: ?>
    <div class="grid g4">
      <?php foreach ($featured as $m): $detail = false; include BASE_PATH . '/views/menu/_card.php'; endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<!-- Tentang -->
<section class="section grid g2" id="tentang">
  <div>
    <h2>Sekilas Tentang Kami</h2>
    <p><?= e(app('tentang')) ?></p>
  </div>
  <div class="ph" style="min-height:200px">foto rumah makan</div>
</section>

<!-- Lokasi -->
<section class="section" id="lokasi">
  <h2>Temukan Kami</h2>
  <div class="grid" style="grid-template-columns:2fr 1fr">
    <div class="map">
      <?php if (app('maps_embed')): ?>
        <iframe src="<?= e(app('maps_embed')) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      <?php else: ?><div class="ph" style="height:100%;border:0">[ Google Maps ]</div><?php endif; ?>
    </div>
    <div class="card">
      <strong><?= e(app('nama')) ?></strong>
      <p><?= e(app('alamat')) ?></p>
      <p>Buka: <?= e(app('jam_buka')) ?></p>
      <p>Pembayaran: Tunai / QRIS</p>
    </div>
  </div>
</section>

<!-- FAQ ringkas -->
<section class="section">
  <div class="row-between"><h2>Pertanyaan Umum</h2><a class="btn" href="<?= url('faq') ?>">Lihat FAQ</a></div>
  <div class="grid g3">
    <?php foreach ($faqs as $f): ?>
      <div class="card"><strong><?= e($f['judul']) ?></strong><p><?= e($f['isi']) ?></p></div>
    <?php endforeach; ?>
  </div>
</section>

<script>
(function(){
  var s=document.querySelectorAll('#hero .slide'), d=document.querySelectorAll('#hero .dot'), i=0;
  setInterval(function(){
    s[i].classList.remove('on'); d[i].classList.remove('on');
    i=(i+1)%s.length;
    s[i].classList.add('on'); d[i].classList.add('on');
  },4000);
})();
</script>
