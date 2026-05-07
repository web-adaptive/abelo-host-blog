<?php

declare(strict_types=1);

namespace App\Models;

final class Category
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $status
    ) {
    }
}
