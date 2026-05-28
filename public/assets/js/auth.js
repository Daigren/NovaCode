document.addEventListener("DOMContentLoaded", function() {
    const registerForm = document.querySelector('form[action="register.php"]');

    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirm').value;

            // Удаляем старые сообщения об ошибках от JS (если пользователь пробует снова)
            const oldError = document.querySelector('.js-auth-error');
            if (oldError) {
                oldError.remove();
            }

            // Проверки
            if (password.length < 6) {
                event.preventDefault(); // Останавливаем отправку формы
                showError('Пароль должен содержать минимум 6 символов.');
            } else if (password !== confirmPassword) {
                event.preventDefault();
                showError('Пароли не совпадают. Проверьте правильность ввода.');
            }
        });
    }

    // Функция для отрисовки красивой ошибки в стиле твоего сайта
    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'auth-error js-auth-error'; 
        // Стили уже есть в CSS, но дублируем для надежности, если класс не подхватится
        errorDiv.style.backgroundColor = 'rgba(255, 0, 0, 0.1)';
        errorDiv.style.border = '1px solid red';
        errorDiv.style.color = '#ff6b6b';
        errorDiv.style.padding = '10px';
        errorDiv.style.borderRadius = '6px';
        errorDiv.style.marginBottom = '20px';
        errorDiv.style.textAlign = 'center';
        errorDiv.innerText = message;

        // Вставляем блок с ошибкой прямо перед формой
        registerForm.parentNode.insertBefore(errorDiv, registerForm);
    }
});