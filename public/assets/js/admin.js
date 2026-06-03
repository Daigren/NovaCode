document.addEventListener('DOMContentLoaded', loadPendingCourses);

async function loadPendingCourses() {
    const container = document.getElementById('pendingCoursesContainer');
    
    try {
        // Обращаемся к API модерации (оно отдаст только заявки pending)
        const response = await fetch('../api/moderate.php');
        const data = await response.json();

        if (data.status === 'error') {
            container.innerHTML = `<p style="color: #ef4444;">Ошибка: ${data.message}</p>`;
            return;
        }

        if (data.courses.length === 0) {
            container.innerHTML = '<p style="color: #10b981;">Новых заявок нет. Вы отлично поработали!</p>';
            return;
        }

        // Очищаем контейнер и рисуем карточки
        container.innerHTML = '';
        data.courses.forEach(course => {
            const card = document.createElement('div');
            card.style.cssText = 'background: var(--gray-800); border: 1px solid var(--gray-700); padding: 20px; border-radius: 8px; margin-bottom: 15px;';
            
            card.innerHTML = `
                <h3 style="margin-top: 0;">${course.title}</h3>
                <p style="margin: 5px 0; color: var(--text-secondary);">
                    <strong>Категория:</strong> ${course.category_name} | 
                    <strong>Тип:</strong> ${course.type} | 
                    <strong>Автор:</strong> ${course.author_name}
                </p>
                <div style="margin-top: 15px; display: flex; gap: 10px;">
                    <button onclick="moderateCourse(${course.id}, 'approve')" class="button-changes">Одобрить</button>
                    <button onclick="moderateCourse(${course.id}, 'reject')" class="button-changes">Отклонить</button>
                </div>
            `;
            container.appendChild(card);
        });
    } catch (error) {
        console.error(error);
        container.innerHTML = '<p>Ошибка подключения к серверу.</p>';
    }
}

// Функция отправки решения на сервер
async function moderateCourse(courseId, action) {
    // Защита от случайного клика
    if (action === 'reject' && !confirm('Точно отклонить этот курс?')) return;

    try {
        const response = await fetch('../api/moderate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ course_id: courseId, action: action })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            // Перезагружаем список заявок после успешного действия
            loadPendingCourses();
        } else {
            alert('Ошибка: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Критическая ошибка при отправке запроса');
    }
}