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
    <a href="/LAB5/post.php?postId=<?= $post['id'] ?>" class="post__text"><?= $post['post_text'] ?></a>
    <a href="#" class="post__and">ещё</a>
    <p class="post__time"><?= $post['post_time'] ?></p>
</div>