<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\SeedRepository;

/**
 * Сервис запуска сидирования данных.
 */
final class SeedService
{
    private SeedRepository $seedRepository;

    public function __construct(SeedRepository $seedRepository)
    {
        $this->seedRepository = $seedRepository;
    }

    /**
     * Запускает повторное заполнение базы тестовыми данными.
     *
     * @return array{categories:int,posts:int,relations:int}
     */
    public function run(): array
    {
        return $this->seedRepository->reseed();
    }
}
