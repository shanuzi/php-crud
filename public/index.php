<?php
declare(strict_types=1);

// PSR-4 style autoloader for the App\ namespace
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $file = __DIR__ . '/../app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

use App\Controllers\StudentController;
use App\Core\Session;

Session::start();

$routes = ['index', 'create', 'store', 'edit', 'update', 'destroy'];
$action = $_GET['action'] ?? 'index';

if (!in_array($action, $routes, true)) {
    http_response_code(404);
    $action = 'index';
}

(new StudentController())->$action();
