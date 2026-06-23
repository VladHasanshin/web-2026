<?php
require_once 'read_bd.php';

$connection = connectDatabase();
$posts = getAllPostsFromDatabase($connection);

$editIconPath = './img/edit_icon.png';
$heartIconPath = './img/emoji_heart.png';
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Главная страница • Социальная сеть</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./style.css">
        <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <nav class="sidebar">
            <a href="/LAB7/home.php"><img class="sidebar__icon" width="40" height="40" src="./img/home_icon.png" alt="Home" title="Home"></a>
            <a href="/LAB6/profile"><img class="sidebar__icon" width="40" height="40" src="./img/profile_icon.png" alt="Profile" title="Profile"></a>
            <a href="#"><img class="sidebar__icon" width="40" height="40" src="./img/plus_icon.png" alt="Plus" title="New post"></a>
        </nav>
        <div class="feed">
            <?php foreach ($posts as $post): ?>
                <?php include 'post_preview.php'; ?>
            <?php endforeach; ?>
        </div>
    </body>
</html>