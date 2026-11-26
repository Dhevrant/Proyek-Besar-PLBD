<?php
/**
 * Front controller + router.
 * Semua halaman diakses lewat index.php?r=<rute>
 */
define('BASE_PATH', __DIR__);

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();


/* ===================== FUNGSI BANTU (helper) ===================== */
function e($v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function app(?string $key = null)
{
    static $cfg = null;
    $cfg ??= (require BASE_PATH . '/config/database.php')['app'];
    return $key === null ? $cfg : ($cfg[$key] ?? null);
}

function url(string $route = 'home', array $params = []): string
{
    if ($route === 'home' && !$params) return 'index.php';
    return 'index.php?' . http_build_query(['r' => $route] + $params);
}

function redirect(string $route = 'home', array $params = []): void
{
    header('Location: ' . url($route, $params));
    exit;
}

function flash(string $key, ?string $msg = null): ?string
{
    if ($msg !== null) { $_SESSION['flash'][$key] = $msg; return null; }
    $v = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $v;
}

function set_old(array $data): void { $_SESSION['old'] = $data; }
function old(string $key, $default = '') { return $_SESSION['old'][$key] ?? $default; }

function render(string $view, array $data = [], string $layout = 'home/layout'): void
{
    extract($data, EXTR_SKIP);
    ob_start();
    require BASE_PATH . "/views/$view.php";
    $content = ob_get_clean();
    require BASE_PATH . "/views/$layout.php";
    unset($_SESSION['old']);
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    return $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
}
function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}
function csrf_verify(): void
{
    $t = $_POST['_token'] ?? '';
    if (!is_string($t) || !hash_equals($_SESSION['csrf'] ?? '', $t)) {
        http_response_code(419);
        exit('Sesi formulir kedaluwarsa. Silakan kembali dan coba lagi.');
    }
}

/* ---------- Admin ---------- */
function is_admin(): bool { return !empty($_SESSION['admin']); }
function require_admin(): void
{
    if (!is_admin()) { flash('error', 'Silakan login sebagai admin.'); redirect('login'); }
}

/* ---------- Format ---------- */
function rupiah($n): string { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }

function wa_link(string $phone, string $text = ''): string
{
    $d = preg_replace('/\D+/', '', $phone);
    if (str_starts_with($d, '0'))       $d = '62' . substr($d, 1);
    elseif (str_starts_with($d, '8'))   $d = '62' . $d;
    return 'https://wa.me/' . $d . ($text !== '' ? '?text=' . rawurlencode($text) : '');
}

function tgl($dt): string { return date('d/m/Y H:i', strtotime($dt)); }
/* ================================================================= */

spl_autoload_register(function (string $class): void {
    foreach (['controllers', 'models', 'core'] as $dir) {
        $file = BASE_PATH . "/$dir/$class.php";
        if (is_file($file)) { require $file; return; }
    }
});

// rute => [Controller, method, HTTP method, wajib admin?]
$routes = [
    // ---- Publik (tanpa login) ----
    'home'            => ['MenuController',        'home',          'GET'],
    'menu'            => ['MenuController',        'index',         'GET'],
    'order'           => ['OrderController',       'form',          'GET'],
    'order/store'     => ['OrderController',       'store',         'POST'],
    'order/done'      => ['OrderController',       'done',          'GET'],
    'faq'             => ['FaqFeedbackController', 'index',         'GET'],
    'feedback/store'  => ['FaqFeedbackController', 'kirim',         'POST'],
    // ---- Auth admin ----
    'login'           => ['AuthController',        'showLogin',     'GET'],
    'login/proses'    => ['AuthController',        'login',         'POST'],
    'logout'          => ['AuthController',        'logout',        'POST'],
    // ---- Admin ----
    'admin/orders'        => ['OrderController',       'adminIndex',    'GET',  true],
    'admin/orders/update' => ['OrderController',       'adminUpdate',   'POST', true],
    'admin/menu'          => ['MenuController',        'adminIndex',    'GET',  true],
    'admin/menu/save'     => ['MenuController',        'save',          'POST', true],
    'admin/menu/delete'   => ['MenuController',        'delete',        'POST', true],
    'admin/faq'           => ['FaqFeedbackController', 'adminIndex',    'GET',  true],
    'admin/faq/save'      => ['FaqFeedbackController', 'faqSave',       'POST', true],
    'admin/faq/delete'    => ['FaqFeedbackController', 'faqDelete',     'POST', true],
    'admin/feedback/delete' => ['FaqFeedbackController', 'feedbackDelete', 'POST', true],
];

$route = (string)($_GET['r'] ?? 'home');

try {
    if (!isset($routes[$route])) {
        http_response_code(404);
        render('home/error', ['title' => 'Tidak ditemukan', 'pesan' => 'Halaman tidak ditemukan.']);
        exit;
    }
    [$class, $method, $verb] = $routes[$route];
    if ($_SERVER['REQUEST_METHOD'] !== $verb) {
        http_response_code(405);
        exit('Metode tidak diizinkan.');
    }
    if (!empty($routes[$route][3])) require_admin();
    (new $class())->$method();
} catch (Throwable $e) {
    error_log($e);
    http_response_code(500);
    $pesan = app('debug') ? $e->getMessage() : 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
    render('home/error', ['title' => 'Kesalahan', 'pesan' => $pesan]);
}
