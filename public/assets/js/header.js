document.addEventListener('DOMContentLoaded', async function() {
    const profileLink = document.getElementById('navProfileLink');
    
    if (profileLink) {
        try {
            // Спрашиваем бэкенд, авторизован ли пользователь
            const response = await fetch('api/check_auth.php');
            const data = await response.json();
            
            // Меняем ссылку в зависимости от ответа
            if (data.logged_in === true) {
                profileLink.href = 'profil.php'; 
            } else {
                profileLink.href = 'register.php'; 
            }
            
            // Плавно показываем ссылку
            profileLink.style.opacity = '1';
            
        } catch (error) {
            console.error('Ошибка проверки авторизации:', error);
            // Если сервер не ответил, на всякий случай отправляем на регистрацию
            profileLink.href = 'register.php';
            profileLink.style.opacity = '1';
        }
    }
});