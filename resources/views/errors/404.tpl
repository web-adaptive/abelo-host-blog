{extends file='layouts/main.tpl'}

{block name=title}404 Not Found{/block}

{block name=content}
<h1>404</h1>
<p>{$message|escape}</p>
<p><a href="/">На главную</a></p>
{/block}
