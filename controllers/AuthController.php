<?php
class AuthController
{
    public function showLogin(): void
    {
        if (is_admin()) redirect('admin/orders');
        render('auth/login', ['title' => 'Login Admin'], 'auth/layout');
    }

    public function login(): void
    {
        csrf_verify();

        if (($_SESSION['login_lock'] ?? 0) > time()) {
            flash('error', 'Terlalu banyak percobaan. Coba lagi dalam 1 menit.');
            redirect('login');
        }

        $login = trim((string)($_POST['login'] ?? ''));
        $pass  = (string)($_POST['password'] ?? '');
        $user  = $login !== '' ? User::findByLogin($login) : null;

        if ($user && hash_equals((string)$user['password'], $pass)) {
            session_regenerate_id(true);
            unset($_SESSION['login_fail'], $_SESSION['login_lock']);
            $_SESSION['admin'] = [
                'id' => (int)$user['id_user'], 'nama' => $user['nama'], 'email' => $user['email'],
            ];
            redirect('admin/orders');
        }

        $_SESSION['login_fail'] = ($_SESSION['login_fail'] ?? 0) + 1;
        if ($_SESSION['login_fail'] >= 5) {
            $_SESSION['login_lock'] = time() + 60;
            $_SESSION['login_fail'] = 0;
        }
        set_old(['login' => $login]);
        flash('error', 'Email/nomor telepon atau password salah.');
        redirect('login');
    }

    public function logout(): void
    {
        csrf_verify();
        unset($_SESSION['admin']);
        session_regenerate_id(true);
        redirect('home');
    }
}
