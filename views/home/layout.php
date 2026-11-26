<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e(($title ?? 'Beranda') . ' · ' . app('nama')) ?></title>
<?php require BASE_PATH . '/views/home/style.php'; ?>
</head>
<body>
<?php $active = $active ?? ''; ?>
<header class="nav">
  <a class="logo" href="<?= url() ?>"><?= e(app('nama')) ?></a>
  <nav>
    <a href="<?= url() ?>" class="<?= $active === 'home' ? 'on' : '' ?>">Beranda</a>
    <a href="<?= url('menu') ?>" class="<?= $active === 'menu' ? 'on' : '' ?>">Menu</a>
    <a href="<?= url() ?>#lokasi">Lokasi</a>
    <a href="<?= url() ?>#tentang">Tentang Kami</a>
    <a href="<?= url('faq') ?>" class="<?= $active === 'faq' ? 'on' : '' ?>">FAQ</a>
  </nav>
  <a class="btn btn-dark" href="<?= url('order') ?>">Pesan Sekarang</a>
</header>

<div class="container">
  <?php if ($m = flash('error')): ?><div class="alert alert-error"><?= nl2br(e($m)) ?></div><?php endif; ?>
  <?php if ($m = flash('success')): ?><div class="alert alert-success"><?= nl2br(e($m)) ?></div><?php endif; ?>
  <?= $content ?>
</div>

<footer class="footer">
  <div class="in">
    <div><strong><?= e(app('nama')) ?></strong><br><span class="muted"><?= e(app('kota')) ?></span></div>
    <div><strong>Halaman</strong>
      <a href="<?= url('menu') ?>">Menu</a><a href="<?= url() ?>#lokasi">Lokasi</a><a href="<?= url() ?>#tentang">Tentang Kami</a>
    </div>
    <div><strong>Kontak</strong>
      <a href="<?= e(wa_link(app('wa'))) ?>" target="_blank" rel="noopener">WhatsApp</a>
      <a href="<?= e(app('instagram')) ?>" target="_blank" rel="noopener">Instagram</a>
      <a href="<?= url('login') ?>">Login Admin</a>
    </div>
  </div>
</footer>
<a class="btn btn-dark wa-float" href="<?= e(wa_link(app('wa'), 'Halo ' . app('nama') . ', saya butuh bantuan.')) ?>" target="_blank" rel="noopener">WhatsApp: Butuh Bantuan?</a>
</body>
</html>
