<?php

function escape(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function e(?string $value): string
{
    return escape($value);
}

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirect(string $url): void
{
    $cleanUrl = to_clean_url($url);
    header("Location: $cleanUrl");
    exit;
}

function back(): void
{
    $referer = $_SERVER['HTTP_REFERER'] ?? '/dashboard';
    redirect($referer);
}

function to_clean_url(string $url): string
{
    if (preg_match('/^index\.php\?page=([a-zA-Z_]+)(.*)$/', $url, $matches)) {
        $page = $matches[1];
        $rest = $matches[2] ?? '';

        if (preg_match('/&action=([a-zA-Z_]+)(.*)$/', $rest, $actionMatches)) {
            $action = $actionMatches[1];
            $params = $actionMatches[2] ?? '';
            $cleanUrl = '/' . $page . '/' . $action;
        } else {
            $params = $rest;
            $cleanUrl = '/' . $page;
        }

        if (!empty($params)) {
            $params = ltrim($params, '&');
            $cleanUrl .= '?' . $params;
        }

        return $cleanUrl;
    }

    return $url;
}

function old(string $key, string $default = ''): string
{
    return escape($_SESSION['old_input'][$key] ?? $default);
}

function set_old_input(array $data): void
{
    $_SESSION['old_input'] = $data;
}

function clear_old_input(): void
{
    unset($_SESSION['old_input']);
}

function flash(string $key, string $message): void
{
    $_SESSION['flash'][$key] = $message;
}

function get_flash(string $key): ?string
{
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

function has_flash(string $key): bool
{
    return isset($_SESSION['flash'][$key]);
}

function auth(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function is_role(string $role): bool
{
    return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === $role;
}


function format_rupiah(float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

function format_tanggal(string $date): string
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $timestamp = strtotime($date);
    $hari = date('d', $timestamp);
    $bln = (int) date('m', $timestamp);
    $tahun = date('Y', $timestamp);
    return "$hari {$bulan[$bln]} $tahun";
}



function validate_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_number($value): bool
{
    return is_numeric($value) && $value >= 0;
}

function validate_date(string $date, string $format = 'Y-m-d'): bool
{
    $d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


function generate_pairing_code(int $length = 8): string
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $code;
}

function asset(string $path): string
{
    $baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
    return $baseUrl . '/assets/' . ltrim($path, '/');
}

function url(string $page, array $params = []): string
{
    $action = $params['action'] ?? null;
    unset($params['action']);

    $baseUrl = '/' . $page;
    if ($action) {
        $baseUrl .= '/' . $action;
    }
    if (!empty($params)) {
        $baseUrl .= '?' . http_build_query($params);
    }
    return $baseUrl;
}

function view(string $viewPath, array $data = []): void
{
    extract($data);
    $viewFile = dirname(__DIR__, 2) . '/views/' . str_replace('.', '/', $viewPath) . '.php';

    if (file_exists($viewFile)) {
        require $viewFile;
    } else {
        throw new \Exception("View not found: $viewPath");
    }
}

function config(string $key, $default = null)
{
    return $_ENV[$key] ?? $default;
}
