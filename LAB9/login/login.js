document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form');
    const email = document.querySelector('#email');
    const password = document.querySelector('#password');
    const errorBanner = document.querySelector('.form__error-banner');

    if (!form || !email || !password || !errorBanner) return;

    const VALID_CREDENTIALS = {
        email: 'test@mail.ru',
        password: 'password'
    };

    let showError = (message) => {
        errorBanner.textContent = message;
        errorBanner.classList.add('active'); 
    }

    let clearError = () => {
        errorBanner.classList.remove('active');
    };

    let isValidEmail = (emailStr) => {
        // [Текст без пробелов] + [@] + [Текст без пробелов] + [.] + [Текст без пробелов]
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailStr); 
    };

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const emailValue = email.value.trim();
        const passwordValue = password.value;

        if (!emailValue || !passwordValue) {
            showError('🤓 Поля обязательные');
            return;
        }

        if (!isValidEmail(emailValue)) {
            showError('🤓 Неверный формат почты');
            return;
        } 

        if (emailValue !== VALID_CREDENTIALS.email || passwordValue !== VALID_CREDENTIALS.password) {
            showError('🤓 Неверный логин или пароль');
            return;
        }

        alert('Авторизация прошла успешно!');
        window.location.href = '/LAB9/home';
    });

    email.addEventListener('input', clearError);
    password.addEventListener('input', clearError);
});