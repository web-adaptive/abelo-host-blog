<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PostDTO;
use App\Models\Post;
use App\Repositories\PostRepository;

/**
 * Сервис бизнес-логики постов.
 */
final class PostService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Возвращает пост по id.
     *
     * @param int $id Идентификатор поста.
     * @return PostDTO|null
     */
    public function getPost(int $id): ?PostDTO
    {
        $post = $this->postRepository->getPost($id);
        if ($post === null) {
            return null;
        }
        return $this->mapDto($post);
    }

    /**
     * Возвращает посты с пагинацией.
     *
     * @param int $page Номер страницы.
     * @param int $perPage Количество записей на страницу.
     * @param string $sortBy Поле сортировки.
     * @param string $direction Направление сортировки.
     * @return list<PostDTO>
     */
    public function getPaginated(
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'created_at',
        string $direction = 'DESC'
    ): array {
        $rows = $this->postRepository->getPaginated($page, $perPage, $sortBy, $direction);

        return array_map(fn (Post $post): PostDTO => $this->mapDto($post), $rows);
    }

    /**
     * Возвращает посты категории с пагинацией.
     *
     * @param int $categoryId Идентификатор категории.
     * @param int $page Номер страницы.
     * @param int $perPage Количество записей на страницу.
     * @param string $sortBy Поле сортировки.
     * @param string $direction Направление сортировки.
     * @return list<PostDTO>
     */
    public function getPostsByCategoryId(
        int $categoryId,
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'created_at',
        string $direction = 'DESC'
    ): array {
        $rows = $this->postRepository->getPostsByCategoryId($categoryId, $page, $perPage, $sortBy, $direction);

        return array_map(fn (Post $post): PostDTO => $this->mapDto($post), $rows);
    }

    /**
     * Преобразует модель поста в PostDTO.
     * 
     * @param Post $post Модель поста.
     * @return PostDTO
     */
    private function mapDto(Post $post): PostDTO
    {
        return new PostDTO(
            $post->id,
            $post->title,
            $post->description,
            $post->text,
            $post->status,
            $post->img,
            $post->viewsCount,
            $post->sort,
            $post->createdAt,
            $post->updatedAt
        );
    }

    /**
     * Возвращает общее количество постов в категории.
     *
     * @param int $categoryId Идентификатор категории.
     * @return int
     */
    public function countByCategoryId(int $categoryId): int
    {
        return $this->postRepository->countByCategoryId($categoryId);
    }

    /**
     * Возвращает похожие посты для карточки поста.
     *
     * @param int $postId Идентификатор поста.
     * @param int $limit Максимальное количество похожих постов.
     * @return list<PostDTO>
     */
    public function getRelatedPosts(int $postId, int $limit = 3): array
    {
        $rows = $this->postRepository->getRelatedPosts($postId, $limit);

        return array_map(fn (Post $post): PostDTO => $this->mapDto($post), $rows);
    }
}
