const fileInput = document.querySelector('.upload-zone__file-input');
const uploadPlaceholderButton = document.querySelector('.upload-zone-placeholder__button');
const addPhotoTextButton = document.querySelector('.add-photo');
const uploadZonePlaceholder = document.querySelector('.upload-zone-placeholder');
const gallery = document.querySelector('.upload-zone__gallery');
const counter = document.querySelector('.upload-zone__counter');

const prevButton = document.querySelector('.upload-zone__button-nav-prev');
const nextButton = document.querySelector('.upload-zone__button-nav-next');

const textarea = document.querySelector('.text-containter__area');
const shareButton = document.querySelector('.create-post-content__share');

const statusMessage = document.getElementById('statusMessage');
const postContent = document.querySelector('.create-post-content');
const headerTitle = document.querySelector('.create-post-header__title');

let uploadedImages = []; 
let currentIndex = 0;
let editMode = false;
let editPostId = null;

async function initEditMode() {
    const searchString = window.location.search;
    if (!searchString || !searchString.includes('postId=')) return;

    const postId = searchString.split('=')[1];
    if (!postId) return;

    editMode = true;
    editPostId = postId;

    if (headerTitle) headerTitle.textContent = "Редактирование поста";
    if (shareButton) shareButton.textContent = "Сохранить";

    try {
        const response = await fetch(`/LAB9/api/get_post?postId=${postId}`);
        if (!response.ok) throw new Error();
        
        const postData = await response.json();
        textarea.value = postData.post_text;

        if (postData.image_path) {
            const paths = postData.image_path.split(',');
            uploadedImages = [];
            for (let i = 0; i < paths.length; i++) {
                const cleanPath = paths[i].trim();
                if (cleanPath) {
                    uploadedImages.push(cleanPath);
                }
            }
            currentIndex = 0;
            renderGallery();
        }
    } catch {
        statusMessage.textContent = "Ошибка при загрузке данных поста.";
        statusMessage.classList.remove('hidden');
    }
}

initEditMode();

function renderGallery() {
    const totalImages = uploadedImages.length;
    const hasImages = totalImages > 0;
    const hasMultiple = totalImages > 1;

    uploadZonePlaceholder.classList.toggle('hidden', hasImages);
    prevButton.classList.toggle('visible', hasMultiple);
    nextButton.classList.toggle('visible', hasMultiple);
    counter.classList.toggle('visible', hasMultiple);

    if (hasImages) {
        let img = gallery.querySelector('img');
        if (!img) {
            gallery.innerHTML = '<img class="active" src="">';
            img = gallery.querySelector('img');
        }

        const currentItem = uploadedImages[currentIndex];
        
        if (typeof currentItem === 'string') {
            const filename = currentItem.replace(/^\.?\/?/, ''); // Стирает точки и слеши в начале
            img.src = '/LAB9/' + filename;
        } else {
            img.src = URL.createObjectURL(currentItem);
        }

        if (hasMultiple) {
            counter.textContent = (currentIndex + 1) + " / " + totalImages;
        }
    }
    
    validateForm();
}

function validateForm() {
    const hasImages = uploadedImages.length > 0;
    const hasText = textarea.value.trim().length > 0;
    const isReady = hasImages && hasText;

    shareButton.disabled = !isReady;
    shareButton.classList.toggle('active', isReady);
}

function fileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

uploadPlaceholderButton.addEventListener('click', () => fileInput.click());
addPhotoTextButton.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', () => {
    for (let i = 0; i < fileInput.files.length; i++) {
        const file = fileInput.files[i];
        if (file.type.startsWith('image/')) {
            uploadedImages.push(file);
        }
    }
    if (fileInput.files.length > 0) {
        currentIndex = uploadedImages.length - 1;
        renderGallery();
    }
    fileInput.value = '';
});

nextButton.addEventListener('click', () => {
    if (uploadedImages.length === 0) return;
    currentIndex++;
    if (currentIndex >= uploadedImages.length) {
        currentIndex = 0;
    }    
    renderGallery();
});

prevButton.addEventListener('click', () => {
    if (uploadedImages.length === 0) return;
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = uploadedImages.length - 1;
    }    
    renderGallery();
});

textarea.addEventListener('input', validateForm);

shareButton.addEventListener('click', async (e) => {
    e.preventDefault();
    
    shareButton.disabled = true;
    shareButton.classList.remove('active');
    statusMessage.textContent = "Сохранение...";
    statusMessage.classList.remove('hidden');

    try {
        const base64Images = [];
        const existingPaths = [];

        for (let i = 0; i < uploadedImages.length; i++) {
            const item = uploadedImages[i];
            if (typeof item === 'string') {
                existingPaths.push(item);
            } else {
                const base64String = await fileToBase64(item);
                base64Images.push(base64String);
            }
        }

        const postData = {
            user_id: 1,
            post_text: textarea.value.trim(),
            images: base64Images,
            existing_images: existingPaths
        };

        let url = '/LAB9/api/new_post';
        if (editMode) {
            postData.post_id = editPostId;
            url = '/LAB9/api/edit_post';
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(postData)
        });

        if (response.ok) {
            postContent.classList.add('hidden');
            statusMessage.textContent = editMode ? "Пост успешно обновлен!" : "Пост успешно сохранен!";
        } else {
            throw new Error();
        }

    } catch (error) {
        console.error(error);
        statusMessage.textContent = "Не удалось сохранить пост. Попробуйте еще раз.";
        shareButton.disabled = false;
        shareButton.classList.add('active');
    }
});