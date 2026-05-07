{extends file='layouts/main.tpl'}

{block name=title}500 Internal Server Error{/block}

{block name=content}
<h1>500</h1>
<p>{$message|escape}</p>
<p><a href="/">На главную</a></p>
{/block}
