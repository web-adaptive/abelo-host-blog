<?php

declare(strict_types=1);

use App\Database\DatabaseConnection;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/app/Config/env.php';

$showErrors = filter_var($_ENV['ERROR_INFO'] ?? false, FILTER_VALIDATE_BOOL);

ini_set('display_errors', $showErrors ? '1' : '0');
ini_set('display_startup_errors', $showErrors ? '1' : '0');
error_reporting($showErrors ? E_ALL : 0);

$database = DatabaseConnection::getInstance()->getConnection();

echo 'Application started. Database connection is ready.';
