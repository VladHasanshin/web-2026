<div class="post">
    <div class="user">
        <div class="user-info">
            <img class="user-info__image" width="32" height="32" src="<?= $post['avatar_path'] ?>" alt="<?= $post['user_name'] ?>" title="User title">
            <p class="user-info__name" title="Username"><?= $post['user_name'] ?></p>
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
    <a href="/LAB9/post.php?postId=<?= $post['id'] ?>" class="post__text"><?= htmlspecialchars($post['post_text']) ?></a>
    <span class="post__and">ещё</span>
    <p class="post__time"><?= date('d.m.Y H:i', strtotime($post['post_time'])) ?></p>
</div>