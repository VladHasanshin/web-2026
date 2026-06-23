<?php

$posts = [
    [
        'id' => 1,
        'user_image' => './img/vanya_denisov.jpg',
        'alt_user' => 'Vanya Denisov',
        'user_name' => 'Ваня Денисов',
        'edit_icon' => './img/edit_icon.png',
        'post_image' => './img/winter_street.jpg',
        'alt_post' => 'Winter street',
        'reaction_image' => './img/emoji_heart.png',
        'reaction_count' => '203',
        'post_text' => 'Так красиво сегодня на улице! Настоящая зима)) Вспоминается 
            Бродский: «Поздно ночью, в уснувшей долине, на самом дне, в городке, 
            занесенном снегом по ручку двери...»',
        'post_time' => date('d-m-y H:i:s', strtotime('-2 hours')),
    ],
    [
        'id' => 2,
        'user_image' => './img/liza_demina.jpg',
        'alt_user' => 'Liza Demina',
        'user_name' => 'Лиза Дёмина',
        'edit_icon' => './img/edit_icon.png',
        'post_image' => './img/book_and_fish.jpg',
        'alt_post' => 'Book and fish',
        'reaction_image' => './img/emoji_heart.png',
        'reaction_count' => '523',
        'post_text' => 'Иногда счастье — это всего лишь хорошая книга, уютный вечер
            и такие маленькие гастрономические удовольствия. В этом есть своя поэзия.',
        'post_time' => date('d-m-y H:i:s', strtotime('-5 days')),
    ],
];

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
            <a href="/LAB5/home.php"><img class="sidebar__icon" width="40" height="40" src="./img/home_icon.png" alt="Home"></a>
            <a href="/LAB6/profile"><img class="sidebar__icon" width="40" height="40" src="./img/profile_icon.png" alt="Profile"></a>
            <a href="#"><img class="sidebar__icon" width="40" height="40" src="./img/plus_icon.png" alt="Plus"></a>
        </nav>
        <div class="feed">
            <?php
            foreach ($posts as $post) {
                include 'post_preview.php';
            }
            ?>
        </div>
    </body>
</html>   