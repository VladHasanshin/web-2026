function initPostSlider(sliderContainer) {
    const photos = sliderContainer.querySelectorAll('.post-slider-gallery__photo');
    const counter = sliderContainer.querySelector('.post-slider__counter');
    const modalCounter = document.querySelector('.modal-slider__counter');
    const buttonPrev = sliderContainer.querySelector('.post-slider__button-prev');
    const buttonNext = sliderContainer.querySelector('.post-slider__button-next');
    let currentIndex = 0;
    const totalPhotos = photos.length;
    const controls = [buttonPrev, buttonNext, counter];

    if (totalPhotos === 0) return;

    if (totalPhotos <= 1) {
        controls.forEach(control => {
            if (control) control.classList.add('hidden')
        })
    }

    function updatePhotoStatus() {
        for (let index = 0; index < totalPhotos; index++) {
            const photo = photos[index];
            if (index === currentIndex) {
                photo.classList.add("active");
            } else {
                photo.classList.remove("active");
            }
        }
        if (sliderContainer.classList.contains('modal-slider') && modalCounter) {
            modalCounter.textContent = (currentIndex + 1) + " из " + totalPhotos;
        } else if (counter) {
            counter.textContent = (currentIndex + 1) + "/" + totalPhotos;
        }
    }

    buttonNext.addEventListener("click", () => {
        currentIndex++;
        if (currentIndex >= totalPhotos) {
            currentIndex = 0;
        }
        updatePhotoStatus();
    })

    buttonPrev.addEventListener("click", () => {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = totalPhotos - 1;
        }
        updatePhotoStatus();
    })

    updatePhotoStatus();
}

function initModalWindow() {
    const modal = document.querySelector('.modal-window');
    const modalGallery = document.getElementById('modalGallery');
    const closeButton = document.querySelector('.modal-window__content-button');
    const modalSliderContainer = document.querySelector('.modal-slider');
    const postGalleries = document.querySelectorAll('.post-slider-gallery');
    
    if (!modal || !modalGallery || !closeButton || !modalSliderContainer) return;

    let handleEscPress = (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    }

    let closeModal = () => {
        modal.classList.remove('active');
        modalGallery.innerHTML = '';
        document.removeEventListener('keydown', handleEscPress);
    }

    for (let i = 0; i < postGalleries.length; i++) {
        const gallery = postGalleries[i];

        gallery.addEventListener('click', (event) => {
            if (gallery.closest('.modal-slider') || event.target.closest('.modal-slider')) {
                return;
            }

            modalGallery.innerHTML = '';
            const originalPhotos = gallery.querySelectorAll('.post-slider-gallery__photo');

            for (let j = 0; j < originalPhotos.length; j++) {
                const originalSrc = originalPhotos[j].getAttribute('src');
                const newPhoto = document.createElement('img');

                newPhoto.setAttribute('src', originalSrc);
                newPhoto.setAttribute('width', '474');
                newPhoto.setAttribute('height', '474');
                newPhoto.className = 'post-slider-gallery__photo';
                modalGallery.appendChild(newPhoto);
            }
            modal.classList.add('active');
            initPostSlider(modalSliderContainer);
            document.addEventListener('keydown', handleEscPress);
        });
    }
    closeButton.addEventListener('click', closeModal);
}

function initTextCollapsing() {
    const posts = document.querySelectorAll('.post');
    const MAX_HEIGHT = 36;
    for (let i = 0; i < posts.length; i++) {
        const post = posts[i];
        const text = post.querySelector('.post__text');
        const moreButton = post.querySelector('.post__and');

        if (!text || !moreButton) continue;
        if (text.scrollHeight > MAX_HEIGHT) {
            moreButton.classList.add('visible');
        }

        moreButton.addEventListener('click', () => {
            text.classList.toggle('expanded');
            if (text.classList.contains('expanded')) {
                moreButton.textContent = 'свернуть';
            } else {
                moreButton.textContent = 'ещё';
            }
        })
    }
}

function initPostLikes() {
    const reactionBlocks = document.querySelectorAll('.reaction');
    for (let i = 0; i < reactionBlocks.length; i++) {
        const block = reactionBlocks[i];
        block.addEventListener('click', async () => {
            const postId = block.querySelector('.post-id-input').value;
            const countElement = block.querySelector('.reaction__emoji-count');
            const errorElement = block.querySelector('.reaction__error');
            const isLiked = block.classList.contains('liked');
            const action = isLiked ? 'remove' : 'add';

            if (errorElement) {
                errorElement.textContent = '';
                errorElement.classList.add('hidden');
            }

            try {
                const response = await fetch('/LAB9/api/like_post', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        post_id: postId,
                        action: action
                    })
                });

                if (!response.ok) throw new Error();

                const result = await response.json();

                if (result.success) {
                    countElement.textContent = result.likes_count;
                    block.classList.toggle('liked', !isLiked);
                }
            } catch (error) {
                if (errorElement) {
                    errorElement.textContent = "Ошибка";
                    errorElement.classList.remove('hidden');
                }
            }
        });
    }    
}

document.addEventListener('DOMContentLoaded', () => {
    const allPhotosOnPage = document.querySelectorAll('.post-slider');
    for (let i = 0; i < allPhotosOnPage.length; i++) {
        if (!allPhotosOnPage[i].classList.contains('modal-slider')) {
            initPostSlider(allPhotosOnPage[i]);
        }
    }
    initModalWindow();
    initTextCollapsing();
    initPostLikes();
});