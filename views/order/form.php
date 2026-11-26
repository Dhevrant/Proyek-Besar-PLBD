<h1>Form Pemesanan</h1>
<p class="muted">Tanpa login. Isi data, kirim, lalu admin menghubungi lewat WhatsApp.</p>

<form method="post" action="<?= url('order/store') ?>" id="orderForm">
  <?= csrf_field() ?>
  <div class="grid" style="grid-template-columns:2fr 1fr;align-items:start">

    <div>
      <div class="card">
        <h2>Data Pemesan</h2>
        <label for="nama">Nama pelanggan *</label>
        <input id="nama" name="nama" required maxlength="100" value="<?= e(old('nama')) ?>">
        <label for="telepon">Nomor telepon / WhatsApp *</label>
        <input id="telepon" name="telepon" required inputmode="tel" maxlength="20" placeholder="08xxxxxxxxxx" value="<?= e(old('telepon')) ?>">
        <label for="alamat">Alamat * (untuk pengantaran)</label>
        <textarea id="alamat" name="alamat"><?= e(old('alamat')) ?></textarea>
        <label for="email">Email (opsional)</label>
        <input id="email" name="email" type="email" maxlength="100" value="<?= e(old('email')) ?>">
      </div>

      <div class="card" style="margin-top:1rem">
        <div class="row-between">
          <h2>Menu yang Dipesan</h2>
          <a class="btn btn-sm" href="<?= url('menu') ?>" target="_blank" rel="noopener">Lihat daftar menu</a>
        </div>
        <div id="items"></div>
        <p id="emptyMsg" class="muted">Belum ada menu dipilih.</p>
        <select id="addMenu" aria-label="Tambah menu lain" style="margin-top:.8rem"></select>
      </div>
    </div>

    <div>
      <div class="card">
        <h2>Pengambilan &amp; Pembayaran</h2>
        <strong>Metode pengambilan</strong>
        <?php $amb = old('pengambilan', 'ambil'); ?>
        <label class="radio"><input type="radio" name="pengambilan" value="ambil" <?= $amb === 'ambil' ? 'checked' : '' ?>> Ambil sendiri di outlet</label>
        <label class="radio"><input type="radio" name="pengambilan" value="antar" <?= $amb === 'antar' ? 'checked' : '' ?>> Diantar ke alamat</label>
        <br><strong>Metode pembayaran</strong>
        <?php $byr = old('pembayaran', 'tunai'); ?>
        <label class="radio"><input type="radio" name="pembayaran" value="tunai" <?= $byr === 'tunai' ? 'checked' : '' ?>> Tunai</label>
        <label class="radio"><input type="radio" name="pembayaran" value="qris" <?= $byr === 'qris' ? 'checked' : '' ?>> QRIS</label>
      </div>

      <div class="card" style="margin-top:1rem">
        <h2>Total</h2>
        <div class="total"><span>Total harga</span><span id="total">Rp 0</span></div>
        <button class="btn btn-dark btn-block" type="submit">Kirim Pesanan</button>
        <p class="muted">Setelah dikirim: halaman konfirmasi "Pesanan diterima, admin akan menghubungi Anda". Status awal: Baru.</p>
      </div>
    </div>
  </div>
</form>

<script>
const MENUS   = <?= json_encode($menus, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
const INITIAL = <?= json_encode($initial, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const list = document.getElementById('items'), sel = document.getElementById('addMenu'),
      totalEl = document.getElementById('total'), emptyMsg = document.getElementById('emptyMsg');

function refreshSelect() {
  sel.innerHTML = '';
  const o = document.createElement('option'); o.value = ''; o.textContent = '+ Tambah menu lain ▾'; sel.appendChild(o);
  MENUS.forEach(m => {
    const op = document.createElement('option'); op.value = m.id; op.textContent = m.nama + ' — ' + rp(m.harga); sel.appendChild(op);
  });
}

function recalc() {
  let total = 0, n = 0;
  list.querySelectorAll('.item-row').forEach(row => {
    const m = MENUS.find(x => x.id == row.dataset.id), q = parseInt(row.querySelector('input[name="jumlah[]"]').value) || 0;
    const sub = m.harga * q; total += sub; n++;
    row.querySelector('.sub').textContent = rp(sub);
  });
  totalEl.textContent = rp(total);
  emptyMsg.style.display = n ? 'none' : '';
}

function addItem(id, qty) {
  const m = MENUS.find(x => x.id == id);
  if (!m) return;                                   // menu habis / tidak ada
  const exist = list.querySelector('.item-row[data-id="' + id + '"] input[name="jumlah[]"]');
  if (exist) { exist.value = Math.min(99, (parseInt(exist.value) || 0) + qty); recalc(); return; }

  const row = document.createElement('div'); row.className = 'item-row'; row.dataset.id = id;
  const name = document.createElement('strong'); name.textContent = m.nama;
  const price = document.createElement('span'); price.className = 'muted'; price.textContent = rp(m.harga);
  const hid = document.createElement('input'); hid.type = 'hidden'; hid.name = 'menu_id[]'; hid.value = id;
  const qWrap = document.createElement('div'); qWrap.className = 'qty';
  const minus = document.createElement('button'); minus.type = 'button'; minus.textContent = '−';
  const num = document.createElement('input'); num.type = 'number'; num.name = 'jumlah[]'; num.min = 1; num.max = 99; num.value = qty;
  const plus = document.createElement('button'); plus.type = 'button'; plus.textContent = '+';
  const sub = document.createElement('strong'); sub.className = 'sub';
  const del = document.createElement('button'); del.type = 'button'; del.className = 'btn btn-sm'; del.textContent = 'Hapus';

  minus.onclick = () => { num.value = Math.max(1, (parseInt(num.value) || 1) - 1); recalc(); };
  plus.onclick  = () => { num.value = Math.min(99, (parseInt(num.value) || 0) + 1); recalc(); };
  num.oninput = recalc;
  del.onclick = () => { row.remove(); recalc(); };

  qWrap.append(minus, num, plus);
  row.append(name, price, qWrap, sub, hid, del);
  // susun ulang agar kolom: nama | harga | qty | subtotal (hapus di akhir)
  list.appendChild(row); recalc();
}

sel.addEventListener('change', () => { if (sel.value) addItem(sel.value, 1); sel.value = ''; });
refreshSelect();
INITIAL.forEach(i => addItem(i.id, i.qty));
recalc();
</script>
