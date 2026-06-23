<?php
require_once './utils/read_bd.php';

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : null;
$post = null;

if ($postId) {
    $connection = connectDatabase();
    $post = getPostById($connection, $postId);
}

if (!$post) {
    http_response_code(404);
    echo 'Пост не найден. Проверьте параметр postId в адресной строке.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= !empty($post['title']) ? htmlspecialchars($post['title']) : 'Пост - ' . htmlspecialchars($post['user_name']) ?></title>
    <script src="./post.js"></script>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <nav class="sidebar">
        <a href="/LAB9/home"><img class="sidebar__icon" width="24" height="24" src="./img/home.svg" alt="Home" title="Home"></a>
        <a href="/LAB9/profile"><img class="sidebar__icon" width="24" height="24" src="./img/user.svg" alt="Profile" title="Profile"></a>
        <a href="/LAB9/create_post"><img class="sidebar__icon" width="24" height="24" src="./img/plus.svg" alt="Plus" title="New post"></a>
    </nav>
    <div class="feed">
        <div class="post">
            <div class="user">
                <div class="user-info">
                    <img class="user-info__image" width="32" height="32" src="<?= $post['avatar_path'] ?>" alt="<?= htmlspecialchars($post['user_name']) ?>" title="User title">
                    <p class="user-info__name" title="Username"><?= htmlspecialchars($post['user_name']) ?></p>
                </div>
                <a href="/LAB9/create_post?postId=<?= $post['id'] ?>">
                    <img class="user__edit-icon" width="24" height="24" src="./img/edit.svg" alt="Edit" title="Edit">
                </a>
            </div>
            <div class="post-slider">
                <button class="post-slider__button post-slider__button-prev">&lt</button>
                <button class="post-slider__button post-slider__button-next">&gt</button>
                <div class="post-slider-gallery">
                    <?php 
                    $images = explode(',', $post['image_path']); 
                    foreach ($images as $index => $imageSrc): 
                        $imageSrc = trim($imageSrc); 
                    ?>
                        <img class="post-slider-gallery__photo" width="474" height="474" src="<?= htmlspecialchars($imageSrc) ?>" alt="Post_image <?= $index + 1 ?>" title="Post title <?= $index + 1 ?>">
                    <?php endforeach; ?>
                </div>
                <div class="post-slider__counter"></div>
            </div>
            <button class="reaction" value="<?= $post['id'] ?>">
                <input type="hidden" class="post-id-input" value="<?= $post['id'] ?>">
                <img class="reaction__emoji" width="16" height="16" src="./img/emoji_heart.png" alt="Heart" title="Heart">
                <span class="reaction__emoji-count"><?= $post['likes_count'] ?></span>
                <span class="reaction__error hidden"></span>
            </button>
            <p class="post__text"><?= htmlspecialchars($post['post_text'])?></p>
            <span class="post__and">ещё</span>
            <p class="post__time"><?= date('d.m.Y H:i', strtotime($post['post_time'])) ?></p>
            <a href="/LAB9/home">Вернуться к постам</a>
        </div>
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