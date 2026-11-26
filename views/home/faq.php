<div style="max-width:760px;margin:0 auto">
  <h1>Pertanyaan yang Sering Ditanyakan</h1>
  <?php if (!$faqs): ?><p class="muted">Belum ada FAQ.</p><?php endif; ?>
  <?php foreach ($faqs as $f): ?>
    <details class="faq"><summary><?= e($f['judul']) ?></summary><p><?= nl2br(e($f['isi'])) ?></p></details>
  <?php endforeach; ?>

  <div class="card" style="margin-top:2rem">
    <h2>Kritik dan Saran</h2>
    <form method="post" action="<?= url('feedback/store') ?>">
      <?= csrf_field() ?>
      <input class="hp" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
      <label for="nama">Nama (opsional)</label>
      <input id="nama" name="nama" maxlength="100" value="<?= e(old('nama')) ?>">
      <label for="isi">Kritik atau saran Anda</label>
      <textarea id="isi" name="isi" required minlength="5" maxlength="1000" placeholder="Tulis kritik atau saran Anda..."><?= e(old('isi')) ?></textarea>
      <p><button class="btn btn-dark" type="submit">Kirim</button></p>
      <p class="muted">Masukan masuk ke dashboard admin; tanpa login.</p>
    </form>
  </div>
</div>
