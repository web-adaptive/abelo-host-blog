{extends file='layouts/main.tpl'}

{block name=title}{$title|escape}{/block}

{block name=content}
{if $categories|@count > 0}
    {foreach $categories as $category}
        <section class="category-section">
            <div class="category-head">
                <h2>{$category.title|escape}</h2>
                <a href="/category/{$category.id|escape}" class="all-link">View All</a>
            </div>

            <div class="posts-grid">
                {foreach $category.posts as $post}
                    <article class="post-card">
                        <a href="/post/{$post.id|escape}" class="post-image-link">
                            <img src="{$post.img|default:'/assets/images/posts/cat-1.png'|escape}" alt="{$post.title|escape}" class="post-image">
                        </a>
                        <h3><a href="/post/{$post.id|escape}">{$post.title|escape}</a></h3>
                        <small>{$post.created_at|escape}</small>
                        <p>{$post.description|default:'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'|escape}</p>
                        <a href="/post/{$post.id|escape}" class="read-more">Continue Reading</a>
                    </article>
                {/foreach}
            </div>
        </section>
    {/foreach}
{else}
    <p>Категории со статьями пока не добавлены.</p>
{/if}
{/block}
