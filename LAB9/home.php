<?php
require_once './utils/read_bd.php';

$connection = connectDatabase();
$posts = getAllPostsFromDatabase($connection);
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Главная страница • Социальная сеть</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./style.css">
        <script src="./post.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <nav class="sidebar">
            <a href="/LAB9/home"><img class="sidebar__icon" width="24" height="24" src="./img/home.svg" alt="Home" title="Home"></a>
            <a href="/LAB9/profile"><img class="sidebar__icon" width="24" height="24" src="./img/user.svg" alt="Profile" title="Profile"></a>
            <a href="/LAB9/create_post"><img class="sidebar__icon" width="24" height="24" src="./img/plus.svg" alt="Plus" title="New post"></a>
        </nav>
        <div class="feed">
            <?php foreach ($posts as $post): ?>
                <?php include 'post_preview.php'; ?>
            <?php endforeach; ?>
        </div>

        <div class="modal-window">
            <div class="modal-window__content">
                <button class="modal-window__content-button">&times</button>
                <div class="post-slider modal-slider">
                    <button class="post-slider__button post-slider__button-prev">&lt</button>
                    <button class="post-slider__button post-slider__button-next">&gt</button>
                    <div class="post-slider-gallery" id="modalGallery"></div>
                </div>
                <div class="modal-slider__counter"></div>
            </div>
        </div>
    </body>
</html>