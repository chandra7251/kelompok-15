<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'index';

$routes = [
    'login' => ['controller' => 'AuthController', 'actions' => ['index' => 'showLogin', 'submit' => 'login']],
    'register' => ['controller' => 'AuthController', 'actions' => ['index' => 'showRegister', 'submit' => 'register']],
    'logout' => ['controller' => 'AuthController', 'actions' => ['index' => 'logout']],
    'forgot_password' => ['controller' => 'ForgotPasswordController', 'actions' => ['index' => 'index', 'submit' => 'submit']],
    'dashboard' => ['controller' => 'DashboardController', 'actions' => ['index' => 'index']],
    'profile' => ['controller' => 'ProfileController', 'actions' => ['index' => 'index', 'update_password' => 'updatePassword']],
    'transaksi' => ['controller' => 'TransaksiController', 'actions' => ['index' => 'index', 'create' => 'create', 'store' => 'store', 'edit' => 'edit', 'update' => 'update', 'delete' => 'delete']],
    'kategori' => ['controller' => 'KategoriController', 'actions' => ['index' => 'index', 'create' => 'create', 'store' => 'store', 'edit' => 'edit', 'update' => 'update', 'delete' => 'delete']],
    'transfer' => ['controller' => 'TransferController', 'actions' => ['index' => 'index', 'send' => 'store', 'link' => 'linkMahasiswa', 'unlink' => 'unlinkMahasiswa']],
    'analytics' => ['controller' => 'AnalyticsController', 'actions' => ['index' => 'index']],
    'grafik' => ['controller' => 'GrafikController', 'actions' => ['index' => 'index', 'data' => 'getChartData']],
    'export' => ['controller' => 'ExportController', 'actions' => ['transaksi' => 'transaksi', 'laporan' => 'laporan']],
    'reminder' => ['controller' => 'ReminderController', 'actions' => ['index' => 'index', 'store' => 'store', 'delete' => 'delete', 'send' => 'send', 'json' => 'json']],
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
    if ($_ENV['APP_DEBUG'] ?? false) {
        echo "<h1>Error</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
    } else {
        header("Location: index.php?page=login");
        exit;
    }
}
