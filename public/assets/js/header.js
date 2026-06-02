document.addEventListener('DOMContentLoaded', async function() {
    const profileLink = document.getElementById('navProfileLink');
    // Находим шапку, куда будем добавлять ссылку
    const header = document.querySelector('header'); 
    
    if (profileLink) {
        try {
            const response = await fetch('../api/check_auth.php');
            const data = await response.json();
            
            if (data.logged_in === true) {
                profileLink.href = 'profil.php'; 
            } else {
                profileLink.href = 'register.php'; 
            }
            
            profileLink.style.opacity = '1';
            
        } catch (error) {
            console.error('Ошибка проверки авторизации:', error);
            profileLink.href = 'register.php';
            profileLink.style.opacity = '1';
        }
    }
});