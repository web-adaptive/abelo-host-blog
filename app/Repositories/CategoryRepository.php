<?php

declare(strict_types=1);

namespace App\Repositories;

final class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        return $this->fetchAll(
            'SELECT id, title, description, status FROM category ORDER BY id DESC'
        );
    }

    public function getCategory(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT id, title, description, status FROM category WHERE id = :id LIMIT 1',
            ['id' => $id]
        );
    }
}
