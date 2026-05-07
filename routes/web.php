<?php

declare(strict_types=1);

use App\Controllers\CategoryControllers;
use App\Controllers\HomeControllers;
use App\Controllers\PostsControllers;
use App\Controllers\SeedControllers;
use App\Http\Response;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\SeedRepository;
use App\Routing\Router;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\SeedService;
use App\View\ViewRenderer;

return static function (\PDO $connection): Router {
    $view = new ViewRenderer();
    $response = new Response();

    $categoryRepository = new CategoryRepository($connection);
    $postRepository = new PostRepository($connection);
    $seedRepository = new SeedRepository($connection);

    $categoryService = new CategoryService($categoryRepository);
    $postService = new PostService($postRepository);
    $seedService = new SeedService($seedRepository);

    $homeController = new HomeControllers($view, $response, $categoryService);
    $categoryController = new CategoryControllers($view, $response, $categoryService);
    $postController = new PostsControllers($view, $response, $postService);
    $seedController = new SeedControllers($view, $response, $seedService);

    $router = new Router();
    $router->get('/', [$homeController, 'index']);
    $router->get('/category/{id}', [$categoryController, 'show']);
    $router->get('/post/{id}', [$postController, 'show']);
    $router->get('/seed/run', [$seedController, 'run']);

    return $router;
};
