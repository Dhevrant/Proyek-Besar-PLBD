<div class="card" style="max-width:520px;margin:2rem auto;text-align:center">
  <h2><?= e($title ?? 'Kesalahan') ?></h2>
  <p><?= e($pesan ?? '') ?></p>
  <a class="btn btn-dark" href="<?= url() ?>">Kembali ke Beranda</a>
</div>
