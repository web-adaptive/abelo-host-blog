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

<section class="category-section">
    <div class="category-head">
        <h2>Похожие статьи</h2>
    </div>

    {if $relatedPosts|@count > 0}
        <div class="posts-grid">
            {foreach $relatedPosts as $related}
                <article class="post-card">
                    <a href="/post/{$related->id|escape}" class="post-image-link">
                        <img
                            src="{$related->img|default:'/assets/images/posts/cat-1.png'|escape}"
                            alt="{$related->title|escape}"
                            class="post-image"
                        >
                    </a>
                    <h3><a href="/post/{$related->id|escape}">{$related->title|escape}</a></h3>
                    <small>{$related->createdAt|default:'-'|escape}</small>
                    <p>{$related->description|default:'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'|escape}</p>
                    <a href="/post/{$related->id|escape}" class="read-more">Continue Reading</a>
                </article>
            {/foreach}
        </div>
    {else}
        <p>Похожие статьи не найдены.</p>
    {/if}
</section>
<p><a href="/">На главную</a></p>
{/block}
