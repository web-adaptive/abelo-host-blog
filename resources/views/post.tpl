{extends file='layouts/main.tpl'}

{block name=title}{$title|escape}{/block}

{block name=content}
<h1>{$post->title|escape}</h1>
<p>ID: {$post->id|escape}</p>
<p>{$post->description|escape}</p>
<article>{$post->text|escape}</article>
{if $post->img}
    <p><img src="{$post->img|escape}" alt="{$post->title|escape}" style="max-width: 280px; height: auto;"></p>
{else}
    <p>Изображение: -</p>
{/if}
<p>Просмотры: {$post->viewsCount|escape}</p>
<p>Сортировка: {$post->sort|escape}</p>
<p>Статус: {$post->status|escape}</p>
<p>Опубликовано: {$post->createdAt|default:'-'|escape}</p>
<p>Обновлено: {$post->updatedAt|default:'-'|escape}</p>

<h2>Похожие статьи</h2>
{if $relatedPosts|@count > 0}
    <ul>
        {foreach $relatedPosts as $related}
            <li>
                <a href="/post/{$related->id|escape}">{$related->title|escape}</a>
                <small>({$related->createdAt|default:'-'|escape})</small>
            </li>
        {/foreach}
    </ul>
{else}
    <p>Похожие статьи не найдены.</p>
{/if}
<p><a href="/">На главную</a></p>
{/block}
