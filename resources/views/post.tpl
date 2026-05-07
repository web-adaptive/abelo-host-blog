<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
<h1>{$post->title|escape}</h1>
<p>{$post->description|escape}</p>
<article>{$post->text|escape}</article>
<p>Просмотры: {$post->viewsCount|escape}</p>
<p>Статус: {$post->status|escape}</p>
<p><a href="/">На главную</a></p>
</div>
</body>
</html>
