<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Response;
use App\Services\PostService;
use App\View\ViewRenderer;

final class PostsControllers extends BaseController
{
    public function __construct(
        ViewRenderer $view,
        Response $response,
        private readonly PostService $postService
    ) {
        parent::__construct($view, $response);
    }

    public function show(int $id): void
    {
        $post = $this->postService->getPost($id);

        if ($post === null) {
            throw new NotFoundException('Post not found');
        }

        $this->render('post.tpl', [
            'title' => 'Пост',
            'post' => $post,
        ]);
    }
}
