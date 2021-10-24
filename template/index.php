<?php use BunnyPHP\BunnyPHP; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $_LANG['welcome'] ?></title>
    <style>
        body {
            width: 35em;
            margin: 0 auto;
            text-align: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .logo {
            width: 400px;
            margin-top: 25%;
        }
    </style>
</head>
<body>
<a href="https://github.com/IvanLuLyf/BunnyPHP">
    <img src="/static/img/logo.png" class="logo" alt="BunnyPHP">
</a>
<h1><?= $_LANG['greeting'] ?><a href="https://github.com/IvanLuLyf/BunnyPHP">BunnyPHP</a>!</h1>
<p><?= $_LANG['intro'] ?>🎉</p>
<p><em><?= $_LANG['thank'] ?> Ver<?= BunnyPHP::BUNNY_VERSION ?></em></p>
</body>
</html>