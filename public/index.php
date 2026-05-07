<?php

declare(strict_types=1);

use App\Database\DatabaseConnection;
use App\Exceptions\ExceptionHandler;
use App\Http\Request;
use App\Http\Response;
use App\View\ViewRenderer;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/app/Config/env.php';
require dirname(__DIR__) . '/app/Config/config.php';

$showErrors = (bool) config('app.debug', false);

ini_set('display_errors', $showErrors ? '1' : '0');
ini_set('display_startup_errors', $showErrors ? '1' : '0');
error_reporting($showErrors ? E_ALL : 0);

$request = Request::capture();
$response = new Response();
$exceptionHandler = new ExceptionHandler($response, new ViewRenderer());

try {
    $connection = DatabaseConnection::getInstance()->getConnection();
    $routerFactory = require dirname(__DIR__) . '/routes/web.php';
    $router = $routerFactory($connection);
    $router->dispatch($request);
} catch (Throwable $exception) {
    $exceptionHandler->handle($exception);
}
