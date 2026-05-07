<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{block name=title}{$title|default:'Blog'|escape}{/block}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
{include file='partials/header.tpl'}

<div class="container">
    {block name=content}{/block}
</div>

{include file='partials/footer.tpl'}
</body>
</html>
