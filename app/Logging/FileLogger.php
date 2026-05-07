<?php

declare(strict_types=1);

namespace App\Logging;

/**
 * Простой файловый логгер приложения.
 */
final class FileLogger
{
    private string $logPath;

    /**
     * Создаёт директорию и файл логов при необходимости.
     *
     * @param string $logPath Абсолютный путь к файлу лога.
     * @return void
     */
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

    /**
     * Записывает сообщение уровня ERROR в лог-файл.
     *
     * @param string $message Текст ошибки.
     * @return void
     */
    public function error(string $message): void
    {
        $line = sprintf("[%s] ERROR: %s\n", date('Y-m-d H:i:s'), $message);
        file_put_contents($this->logPath, $line, FILE_APPEND);
    }
}
