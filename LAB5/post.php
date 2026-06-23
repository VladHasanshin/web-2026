<?php
$allPosts = [
    [
        'id' => 1,
        'title' => 'Пост - Ваня Денисов',
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
        'title' => 'Пост - Лиза Дёмина',
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

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : null;
$post = null;
if ($postId !== null) {
    foreach ($allPosts as $item) {
        if ($item['id'] === $postId) {
            $post = $item;
            break;
        }
    }
}
if ($post === null) {
    http_response_code(404);
    echo 'Пост не найден (Ошибка 404). Проверьте параметр postId в адресной строке.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $post['title'] ?></title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <nav class="sidebar">
        <a href="/LAB5/home.php"><img class="sidebar__icon" width="40" height="40" src="./img/home_icon.png" alt="Home"></a>
        <a href="/LAB6/profile"><img class="sidebar__icon" width="40" height="40" src="./img/profile_icon.png" alt="Profile"></a>
        <a href="#"><img class="sidebar__icon" width="40" height="40" src="./img/plus_icon.png" alt="Plus"></a>
    </nav>
    <div class="feed">
        <div class="post">
            <div class="user">
                <div class="user-info">
                    <img class="user-info__image" width="32" height="32" src="<?= $post['user_image'] ?>" alt="<?= $post['alt_user'] ?>">
                    <p class="user-info__name"><?= $post['user_name'] ?></p>
                </div>
                <a href="#"><img class="user__edit-icon" width="36" height="36" src="<?= $post['edit_icon'] ?>" alt="Edit"></a>
            </div>
            <img class="post__image" width="474" height="474" src="<?= $post['post_image'] ?>" alt="<?= $post['alt_post'] ?>">
            <div class="reaction">
                <img class="reaction__emoji" width="16" height="16" src="<?= $post['reaction_image'] ?>" alt="Heart">
                <span class="reaction__emoji-count"><?= $post['reaction_count'] ?></span>
            </div>
            <p class="post__text"><?= $post['post_text'] ?></p>
            <a href="#" class="post__and">ещё</a>
            <p class="post__time"><?= $post['post_time'] ?></p>
            <a href="/LAB5/home.php">Вернуться к постам</a>
        </div>
    </div>    
</body>
</html>