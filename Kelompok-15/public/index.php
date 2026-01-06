<?php

$isProduction = false;

if ($isProduction) {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_PATH', __DIR__);

$autoloadPath = BASE_PATH . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    die('Error: vendor/autoload.php tidak ditemukan. Jalankan "composer install".');
}
require $autoloadPath;

if (file_exists(BASE_PATH . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->safeLoad();
}

$page = $_GET['page'] ?? 'landing';
$action = $_GET['action'] ?? 'index';

$routes = [
    'landing' => ['controller' => 'LandingController', 'actions' => ['index' => 'index']],
    'login' => ['controller' => 'AuthController', 'actions' => ['index' => 'showLogin', 'submit' => 'login']],
    'register' => ['controller' => 'AuthController', 'actions' => ['index' => 'showRegister', 'submit' => 'register']],
    'logout' => ['controller' => 'AuthController', 'actions' => ['index' => 'logout']],
    'forgot_password' => ['controller' => 'ForgotPasswordController', 'actions' => ['index' => 'index', 'submit' => 'submit']],
    'reset_password' => ['controller' => 'ResetPasswordController', 'actions' => ['index' => 'index', 'submit' => 'submit']],
    'dashboard' => ['controller' => 'DashboardController', 'actions' => ['index' => 'index']],
    'profile' => ['controller' => 'ProfileController', 'actions' => ['index' => 'index', 'update_password' => 'updatePassword', 'update_photo' => 'updatePhoto', 'delete_photo' => 'deletePhoto']],
    'transaksi' => ['controller' => 'TransaksiController', 'actions' => ['index' => 'index', 'create' => 'create', 'store' => 'store', 'edit' => 'edit', 'update' => 'update', 'delete' => 'delete']],
    'kategori' => ['controller' => 'KategoriController', 'actions' => ['index' => 'index', 'create' => 'create', 'store' => 'store', 'edit' => 'edit', 'update' => 'update', 'delete' => 'delete']],
    'transfer' => ['controller' => 'TransferController', 'actions' => ['index' => 'index', 'send' => 'store', 'link' => 'linkMahasiswa', 'unlink' => 'unlinkMahasiswa']],
    'analytics' => ['controller' => 'AnalyticsController', 'actions' => ['index' => 'index']],
    'grafik' => ['controller' => 'GrafikController', 'actions' => ['index' => 'index', 'data' => 'getChartData']],
    'export' => ['controller' => 'ExportController', 'actions' => ['transaksi' => 'transaksi', 'laporan' => 'laporan', 'transfer_orangtua' => 'transferOrangtua', 'laporan_anak_pdf' => 'laporanAnakPdf']],
    'reminder' => ['controller' => 'ReminderController', 'actions' => ['index' => 'index', 'store' => 'store', 'delete' => 'delete', 'json' => 'json']],
    'admin' => ['controller' => 'AdminController', 'actions' => ['users' => 'users', 'monitoring' => 'monitoring', 'settings' => 'settings', 'update_settings' => 'updateSettings', 'toggle_status' => 'toggleStatus', 'reset_password' => 'resetPassword', 'delete_user' => 'deleteUser']]
];

try {
    if (!isset($routes[$page])) {
        throw new Exception("Page not found");
    }

    $route = $routes[$page];
    $controllerName = "App\\Controllers\\" . $route['controller'];

    if (!class_exists($controllerName)) {
        throw new Exception("Controller not found");
    }

    $methodName = $route['actions'][$action] ?? $route['actions']['index'] ?? null;
    if (!$methodName) {
        throw new Exception("Action not found");
    }

    $controller = new $controllerName();
    if (!method_exists($controller, $methodName)) {
        throw new Exception("Method not found");
    }

    $controller->$methodName();

} catch (Exception $e) {
    if ($page === 'login' || $page === 'landing') {
        if (!$isProduction) {
            echo "<h1>Error</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
        } else {
            echo "<h1>Terjadi kesalahan</h1><p>Silakan coba lagi nanti.</p>";
        }
    } else {
        if (!$isProduction) {
            echo "<h1>Error</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><a href='/login'>Kembali ke Login</a></p>";
        } else {
            header("Location: /login");
            exit;
        }
    }
}
