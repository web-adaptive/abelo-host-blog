<?php

declare(strict_types=1);

namespace App\Logging;

final class FileLogger
{
    private string $logPath;

    public function __construct(string $logPath)
    {
        $this->logPath = $logPath;
        $directory = dirname($this->logPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        if (!file_exists($this->logPath)) {
            touch($this->logPath);
        }
    }

    public function error(string $message): void
    {
        $line = sprintf("[%s] ERROR: %s\n", date('Y-m-d H:i:s'), $message);
        file_put_contents($this->logPath, $line, FILE_APPEND);
    }
}
