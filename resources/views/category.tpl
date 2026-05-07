{extends file='layouts/main.tpl'}

{block name=title}{$title|escape}{/block}

{block name=content}
<h1>{$category->title|escape}</h1>
<p>{$category->description|escape}</p>
<p>
    Сортировка:
    <a href="/category/{$category->id|escape}?sort=date&direction=DESC">по дате</a> |
    <a href="/category/{$category->id|escape}?sort=views&direction=DESC">по просмотрам</a>
</p>

{if $posts|@count > 0}
    <ul>
        {foreach $posts as $post}
            <li>
                <a href="/post/{$post->id|escape}">{$post->title|escape}</a><br>
                <small>
                    Дата: {$post->createdAt|escape} |
                    Просмотры: {$post->viewsCount|escape}
                </small>
            </li>
        {/foreach}
    </ul>
{else}
    <p>В этой категории пока нет статей.</p>
{/if}

<p>
    Страница {$pagination.current|escape} из {$pagination.total|escape}
</p>
<p>
    {if $pagination.has_prev}
        <a href="/category/{$category->id|escape}?sort={$filters.sort|escape}&direction={$filters.direction|escape}&page={$pagination.prev_page|escape}">Назад</a>
    {/if}
    {foreach $pagination.pages as $pageItem}
        {if $pageItem == '...'}
            <span> ... </span>
        {elseif $pageItem == $pagination.current}
            <strong>{$pageItem|escape}</strong>
        {else}
            <a href="/category/{$category->id|escape}?sort={$filters.sort|escape}&direction={$filters.direction|escape}&page={$pageItem|escape}">{$pageItem|escape}</a>
        {/if}
    {/foreach}
    {if $pagination.has_next}
        <a href="/category/{$category->id|escape}?sort={$filters.sort|escape}&direction={$filters.direction|escape}&page={$pagination.next_page|escape}">Вперед</a>
    {/if}
</p>
<p><a href="/">На главную</a></p>
{/block}
