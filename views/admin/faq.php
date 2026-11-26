<h1>FAQ</h1>
<div class="grid" style="grid-template-columns:3fr 2fr;align-items:start">
  <div class="card">
    <div class="row-between"><h2>Daftar FAQ</h2><a class="btn btn-dark" href="<?= url('admin/faq') ?>">+ Tambah FAQ</a></div>
    <?php if (!$faqs): ?><p class="muted">Belum ada FAQ.</p><?php endif; ?>
    <?php foreach ($faqs as $f): ?>
      <div class="row-between" style="border-bottom:1px dashed #aaa;padding:.6rem 0">
        <div><strong><?= e($f['judul']) ?></strong><br><span class="muted"><?= e($f['isi']) ?></span></div>
        <div style="white-space:nowrap">
          <a class="btn btn-sm" href="<?= url('admin/faq', ['edit' => $f['id_faq_feedback']]) ?>">Edit</a>
          <form class="mini-form" method="post" action="<?= url('admin/faq/delete') ?>" onsubmit="return confirm('Hapus FAQ ini?')">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$f['id_faq_feedback'] ?>">
            <button class="btn btn-sm" type="submit">Hapus</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="card">
    <h2>Form FAQ</h2>
    <form method="post" action="<?= url('admin/faq/save') ?>">
      <?= csrf_field() ?>
      <input type="hidden" name="id_faq_feedback" value="<?= $edit ? (int)$edit['id_faq_feedback'] : 0 ?>">
      <label for="pertanyaan">Pertanyaan *</label>
      <input id="pertanyaan" name="pertanyaan" required maxlength="255" value="<?= e(old('pertanyaan', $edit['judul'] ?? '')) ?>">
      <label for="jawaban">Jawaban *</label>
      <textarea id="jawaban" name="jawaban" required><?= e(old('jawaban', $edit['isi'] ?? '')) ?></textarea>
      <p><button class="btn btn-dark" type="submit">Simpan</button> <?php if ($edit): ?><a class="btn" href="<?= url('admin/faq') ?>">Batal</a><?php endif; ?></p>
    </form>
  </div>
</div>

<h2 style="margin-top:2rem">Kritik &amp; Saran</h2>
<div class="card">
  <h3>Masukan dari Pengguna</h3>
  <div class="table-wrap"><table>
    <tr><th>Tanggal</th><th>Nama</th><th>Isi masukan</th><th></th></tr>
    <?php if (!$feedbacks): ?><tr><td colspan="4" class="muted">Belum ada masukan.</td></tr><?php endif; ?>
    <?php foreach ($feedbacks as $f): ?>
      <tr>
        <td><?= e(tgl($f['created_at'])) ?></td>
        <td><?= e($f['nama_pengirim'] ?: 'Anonim') ?></td>
        <td><?= nl2br(e($f['isi'])) ?></td>
        <td>
          <form class="mini-form" method="post" action="<?= url('admin/feedback/delete') ?>" onsubmit="return confirm('Hapus masukan ini?')">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$f['id_faq_feedback'] ?>">
            <button class="btn btn-sm" type="submit">Hapus</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table></div>
  <p class="muted">Admin hanya membaca; boleh dihapus atau dibiarkan.</p>
</div>
