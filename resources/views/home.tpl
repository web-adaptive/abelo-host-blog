<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
<h1>{$title|escape}</h1>

{if $categories|@count > 0}
    {foreach $categories as $category}
        <section>
            <h2>{$category.title|escape}</h2>
            {if $category.description}
                <p>{$category.description|escape}</p>
            {/if}

            <ul>
                {foreach $category.posts as $post}
                    <li>
                        <a href="/post/{$post.id|escape}">{$post.title|escape}</a>
                        <small>({$post.created_at|escape})</small>
                    </li>
                {/foreach}
            </ul>

            <p>
                <a href="/category/{$category.id|escape}">Все статьи</a>
            </p>
        </section>
    {/foreach}
{else}
    <p>Категории со статьями пока не добавлены.</p>
{/if}
</div>
</body>
</html>
