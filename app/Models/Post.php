<?php

declare(strict_types=1);

namespace App\Models;

final class Post
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $text,
        public readonly string $status,
        public readonly ?string $img,
        public readonly int $viewsCount,
        public readonly int $sort
    ) {
    }
}
