<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
</head>
<body>
<h1>{$post->title|escape}</h1>
<p>{$post->description|escape}</p>
<article>{$post->text|escape}</article>
<p>Просмотры: {$post->viewsCount|escape}</p>
<p>Статус: {$post->status|escape}</p>
<p><a href="/">На главную</a></p>
</body>
</html>
