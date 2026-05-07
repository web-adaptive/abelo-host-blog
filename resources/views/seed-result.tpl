{extends file='layouts/main.tpl'}

{block name=title}{$title|escape}{/block}

{block name=content}
    <h1>{$title|escape}</h1>
    <p>Categories: {$result.categories|escape}</p>
    <p>Posts: {$result.posts|escape}</p>
    <p>Relations: {$result.relations|escape}</p>
    <p><a href="/">На главную</a></p>
{/block}
