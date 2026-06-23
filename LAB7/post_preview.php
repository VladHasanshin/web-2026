<div class="post">
    <div class="user">
        <div class="user-info">
            <img class="user-info__image" width="32" height="32" src="<?= $post['avatar_path'] ?>" alt="<?= $post['user_name'] ?>" title="User title">
            <p class="user-info__name" title="Username"><?= $post['user_name'] ?></p>
        </div>
        <a href="#"><img class="user__edit-icon" width="36" height="36" src="./img/edit_icon.png" alt="Edit" title="Edit"></a>
    </div>
    <img class="post__image" width="474" height="474" src="<?= $post['image_path'] ?>" alt="Post image" title="Post title">
    <div class="reaction">
        <img class="reaction__emoji" width="16" height="16" src="./img/emoji_heart.png" alt="Heart" title="Heart">
        <span class="reaction__emoji-count"><?= $post['likes_count'] ?></span>
    </div>
    <a href="/LAB7/post.php?postId=<?= $post['id'] ?>" class="post__text"><?= htmlspecialchars($post['post_text']) ?></a>
    <a href="#" class="post__and">ещё</a>
    <p class="post__time"><?= date('d.m.Y H:i', strtotime($post['post_time'])) ?></p>
</div>