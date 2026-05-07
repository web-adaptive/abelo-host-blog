<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
</head>
<body>
<h1>{$title|escape}</h1>

{if $categories|@count > 0}
    <ul>
        {foreach $categories as $category}
            <li>
                <a href="/category/{$category->id|escape}">
                    {$category->title|escape}
                </a>
            </li>
        {/foreach}
    </ul>
{else}
    <p>Категории пока не добавлены.</p>
{/if}
</body>
</html>
