<h1>Kelola Menu</h1>
<div class="grid" style="grid-template-columns:3fr 2fr;align-items:start">

  <div class="card">
    <div class="row-between"><h2>Daftar Menu</h2><a class="btn btn-dark" href="<?= url('admin/menu') ?>">+ Tambah Menu</a></div>
    <div class="table-wrap"><table>
      <tr><th>Gambar</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Status</th><th></th></tr>
      <?php foreach ($menus as $m): ?>
        <tr>
          <td style="width:70px">
            <?php if ($m['gambar']): ?><img src="uploads/menu/<?= e($m['gambar']) ?>" alt="" style="width:60px;height:45px;object-fit:cover;border-radius:6px">
            <?php else: ?><div class="ph" style="width:60px;height:45px;font-size:.75rem">img</div><?php endif; ?>
          </td>
          <td><?= e($m['nama_menu']) ?></td>
          <td><?= e($m['kategori']) ?></td>
          <td><?= rupiah($m['harga']) ?></td>
          <td class="<?= $m['status'] === 'tersedia' ? 'st-ok' : 'st-no' ?>"><?= e(Menu::STATUS[$m['status']]) ?></td>
          <td style="white-space:nowrap">
            <a class="btn btn-sm" href="<?= url('admin/menu', ['edit' => $m['id_menu']]) ?>">Edit</a>
            <form class="mini-form" method="post" action="<?= url('admin/menu/delete') ?>"
                  onsubmit="return confirm('Hapus menu &quot;<?= e(addslashes($m['nama_menu'])) ?>&quot;?')">
              <?= csrf_field() ?><input type="hidden" name="id_menu" value="<?= (int)$m['id_menu'] ?>">
              <button class="btn btn-sm" type="submit">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table></div>
    <p class="muted">Hapus: ada konfirmasi dulu. Menu yang diinput otomatis tampil di halaman depan.</p>
  </div>

  <div class="card">
    <h2>Form <?= $edit ? 'Edit' : 'Tambah' ?> Menu</h2>
    <form method="post" action="<?= url('admin/menu/save') ?>" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <input type="hidden" name="id_menu" value="<?= $edit ? (int)$edit['id_menu'] : 0 ?>">
      <?php $v = fn(string $k, $col) => old($k, $edit[$col] ?? ''); ?>

      <label for="nama_menu">Nama menu *</label>
      <input id="nama_menu" name="nama_menu" required maxlength="100" value="<?= e($v('nama_menu', 'nama_menu')) ?>">

      <label for="kategori">Kategori *</label>
      <select id="kategori" name="kategori">
        <?php foreach (Menu::KATEGORI as $k): ?>
          <option <?= $v('kategori', 'kategori') === $k ? 'selected' : '' ?>><?= e($k) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="gambar">Unggah gambar <?= $edit ? '(kosongkan jika tidak diganti)' : '*' ?></label>
      <?php if ($edit && $edit['gambar']): ?><img src="uploads/menu/<?= e($edit['gambar']) ?>" alt="" class="thumb" style="max-width:160px;margin-bottom:.4rem"><?php endif; ?>
      <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" <?= $edit ? '' : 'required' ?>>

      <label for="harga">Harga *</label>
      <input id="harga" name="harga" required inputmode="numeric" pattern="[0-9.]+" title="Hanya angka" value="<?= e($v('harga', 'harga')) ?>">

      <label for="status">Status</label>
      <select id="status" name="status">
        <?php foreach (Menu::STATUS as $k => $label): ?>
          <option value="<?= $k ?>" <?= $v('status', 'status') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
        <?php endforeach; ?>
      </select>

      <label for="deskripsi">Deskripsi (opsional)</label>
      <textarea id="deskripsi" name="deskripsi"><?= e($v('deskripsi', 'deskripsi')) ?></textarea>

      <p><button class="btn btn-dark" type="submit">Simpan</button> <a class="btn" href="<?= url('admin/menu') ?>">Batal</a></p>
      <p class="muted">Validasi: kolom wajib &amp; harga angka. Gambar JPG/PNG/WEBP maks. 2 MB.</p>
    </form>
  </div>
</div>
