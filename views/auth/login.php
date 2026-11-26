<div class="card login-box">
  <h1>Login Admin</h1>
  <form method="post" action="<?= url('login/proses') ?>">
    <?= csrf_field() ?>
    <label for="login">Email / nomor telepon</label>
    <input id="login" name="login" required autocomplete="username" value="<?= e(old('login')) ?>">
    <label for="password">Password</label>
    <input id="password" name="password" type="password" required autocomplete="current-password">
    <p><button class="btn btn-dark btn-block" type="submit">Masuk</button></p>
    <p class="muted">Hanya admin yang punya akun. Pelanggan tidak perlu login.</p>
  </form>
</div>
