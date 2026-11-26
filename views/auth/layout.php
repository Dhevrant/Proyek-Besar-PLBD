<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e(($title ?? 'Login') . ' · ' . app('nama')) ?></title>
<?php require BASE_PATH . '/views/home/style.php'; ?>
</head>
<body>
<header class="nav">
  <a class="logo" href="<?= url() ?>"><?= e(app('nama')) ?></a>
  <a href="<?= url() ?>">← Kembali ke Website</a>
</header>
<div class="container">
  <?php if ($m = flash('error')): ?><div class="alert alert-error"><?= nl2br(e($m)) ?></div><?php endif; ?>
  <?php if ($m = flash('success')): ?><div class="alert alert-success"><?= nl2br(e($m)) ?></div><?php endif; ?>
  <?= $content ?>
</div>
</body>
</html>
