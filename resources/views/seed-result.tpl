<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<div class="container">
    <h1>{$title|escape}</h1>
    <p>Categories: {$result.categories|escape}</p>
    <p>Posts: {$result.posts|escape}</p>
    <p>Relations: {$result.relations|escape}</p>
    <p><a href="/">На главную</a></p>
</div>
</body>
</html>
