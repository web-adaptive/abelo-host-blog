<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
</head>
<body>
<h1>{$category->title|escape}</h1>
<p>{$category->description|escape}</p>
<p>Статус: {$category->status|escape}</p>
<p><a href="/">На главную</a></p>
</body>
</html>
