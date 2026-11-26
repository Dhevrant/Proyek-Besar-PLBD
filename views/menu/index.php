<h1>Daftar Menu</h1>
<div class="filters">
  <form method="get" action="index.php">
    <input type="hidden" name="r" value="menu">
    <?php if ($kategori): ?><input type="hidden" name="kategori" value="<?= e($kategori) ?>"><?php endif; ?>
    <input type="search" name="q" value="<?= e($search) ?>" placeholder="Cari menu...">
  </form>
  <a class="pill <?= $kategori === '' ? 'on' : '' ?>" href="<?= url('menu', array_filter(['q' => $search])) ?>">Semua</a>
  <?php foreach (Menu::KATEGORI as $k): ?>
    <a class="pill <?= $kategori === $k ? 'on' : '' ?>" href="<?= url('menu', array_filter(['kategori' => $k, 'q' => $search])) ?>"><?= e($k) ?></a>
  <?php endforeach; ?>
</div>

<?php if (!$items): ?>
  <p class="muted">Menu tidak ditemukan.</p>
<?php else: ?>
  <div class="grid g4">
    <?php foreach ($items as $m): $detail = true; include BASE_PATH . '/views/menu/_card.php'; endforeach; ?>
  </div>
<?php endif; ?>

<?php if ($pages > 1):
  $link = fn(int $p) => url('menu', array_filter(['q' => $search, 'kategori' => $kategori, 'page' => $p])); ?>
  <div class="pager">
    <?php if ($page > 1): ?><a href="<?= $link($page - 1) ?>">‹</a><?php else: ?><span class="dis">‹</span><?php endif; ?>
    <?php for ($p = 1; $p <= $pages; $p++): ?>
      <?php if ($p === $page): ?><span class="on"><?= $p ?></span><?php else: ?><a href="<?= $link($p) ?>"><?= $p ?></a><?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $pages): ?><a href="<?= $link($page + 1) ?>">›</a><?php else: ?><span class="dis">›</span><?php endif; ?>
  </div>
<?php endif; ?>
