// Показать пароль
function showPassword(eyeImg) {
    const passwordInput = eyeImg.closest('.field_con').querySelector('.changeable');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeImg.src = '../img/svg/eye_open.svg';
    } else {
        passwordInput.type = 'password';
        eyeImg.src = '../img/svg/eye_closed.svg';
    }
}

document.querySelectorAll('.eye_image').forEach(eyeImg => {
    eyeImg.addEventListener('click', function() {
        showPassword(this);
    });
});

// Защита пароля
const passwordSecurity = document.querySelectorAll('.secure');
passwordSecurity.forEach(element => {
    element.addEventListener('copy', function(nocopy) {
        nocopy.preventDefault();
    });
    element.addEventListener('paste', function(nopaste) {
        nopaste.preventDefault();
    });
});

// Заглавные буквы
document.getElementById('user_name').addEventListener('input', function(event) {
    const input = event.target;
    const name = input.value.split(' ').map(word => {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    });
    input.value = name.join(' ');
});