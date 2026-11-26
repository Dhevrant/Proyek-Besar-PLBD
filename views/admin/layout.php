<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e(($title ?? 'Admin') . ' · Admin ' . app('nama')) ?></title>
<?php require BASE_PATH . '/views/home/style.php'; ?>
</head>
<body>
<?php $r = $_GET['r'] ?? ''; $on = fn(string $p) => str_starts_with($r, $p) ? 'on' : ''; ?>
<div class="admin">
  <aside class="side">
    <a class="logo" href="<?= url('admin/orders') ?>">LOGO · Admin</a>
    <a class="<?= $on('admin/orders') ?>" href="<?= url('admin/orders') ?>">Pesanan</a>
    <a class="<?= $on('admin/menu') ?>" href="<?= url('admin/menu') ?>">Kelola Menu</a>
    <a class="<?= $on('admin/faq') ?>" href="<?= url('admin/faq') ?>">FAQ &amp; Kritik Saran</a>
    <hr>
    <a href="<?= url() ?>">← Lihat Website</a>
    <form method="post" action="<?= url('logout') ?>"><?= csrf_field() ?><button class="lnk" type="submit">Keluar</button></form>
    <p class="muted" style="padding:0 .6rem">Masuk sebagai<br><?= e($_SESSION['admin']['nama'] ?? '') ?></p>
  </aside>
  <main class="main">
    <?php if ($m = flash('error')): ?><div class="alert alert-error"><?= nl2br(e($m)) ?></div><?php endif; ?>
    <?php if ($m = flash('success')): ?><div class="alert alert-success"><?= nl2br(e($m)) ?></div><?php endif; ?>
    <?= $content ?>
  </main>
</div>
</body>
</html>
