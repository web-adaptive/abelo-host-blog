<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\SeedRepository;

final class SeedService
{
    private SeedRepository $seedRepository;

    public function __construct(SeedRepository $seedRepository)
    {
        $this->seedRepository = $seedRepository;
    }

    public function run(): array
    {
        return $this->seedRepository->reseed();
    }
}
