function initPopUp(){
    const popup = document.querySelector('.form');
    const popupButton = document.querySelector('.send-form');
    const sendButton = document.querySelector('.form__button');
    const sendFormButton = document.querySelector('.send-form');
    const form = document.querySelector('.form');

    if (!form || !popup || !popupButton || !sendButton || !sendFormButton) return;

    popup.classList.add('hidden');

    function showPopUp() {
        popup.classList.add('active');
    }

    function returnStatus() {
        popup.classList.remove('active');
        sendFormButton.classList.toggle('active');
    }

    function hideSendFormButton() {
        sendFormButton.classList.toggle('hidden'); 
    }

    popupButton.addEventListener('click', showPopUp);
    sendButton.addEventListener('click', returnStatus);
    sendFormButton.addEventListener('click', hideSendFormButton);

    form.addEventListener('submit', () => {
        validateEmail();
    })
}

async function validateEmail(){
    const email = document.querySelector('#email');
    const password = document.querySelector('#password');

    if (!email || !password) return;

    const emailValue = email.value.trim();
    const passwordValue = password.value;

    console.log(emailValue);
    console.log(passwordValue);

    let url = '/EXAM/read_bd.php';
    const response = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
    })
    if (response.ok) {
        if (emailValue !== response.json) {
            console.log('Валидная почта')
        } else {
            console.log('Такая почта уже есть в бд')
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    initPopUp();
})