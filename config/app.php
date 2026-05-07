<?php

declare(strict_types=1);

return [
    'debug' => filter_var($_ENV['ERROR_INFO'] ?? false, FILTER_VALIDATE_BOOL),
    'charset' => 'utf-8',
];
