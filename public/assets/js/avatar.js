document.addEventListener("DOMContentLoaded", function() {
    const avatarInput = document.getElementById('avatar');
    const profileImage = document.querySelector('.profileImage');

    if (avatarInput && profileImage) {
        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                // Проверяем, что это действительно картинка
                if (!file.type.startsWith('image/')) {
                    alert('Пожалуйста, выберите файл изображения (PNG, JPG, WEBP).');
                    avatarInput.value = ''; // Сбрасываем выбор
                    return;
                }

                // Создаем локальную ссылку на файл и подменяем картинку в профиле
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result;
                    // Добавим небольшую неоновую обводку, чтобы показать, что фото готово к загрузке
                    profileImage.style.border = '2px solid var(--neon-cyan)';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});