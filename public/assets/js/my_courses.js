document.addEventListener("DOMContentLoaded", async function() {
    const container = document.querySelector('.myCourses');
    if (!container) return;

    try {
        const response = await fetch('../api/enroll.php');
        const data = await response.json();

        if (data.status === 'error') {
            container.innerHTML = `<p>Ошибка: ${data.message}</p>`;
            return;
        }

        if (data.courses.length === 0) {
            container.innerHTML = '<p>Вы пока не записаны ни на один курс.</p>';
            return;
        }

        container.innerHTML = ''; 
        data.courses.forEach(course => {
            const typeText = course.type === 'online' ? 'Онлайн' : 'Очно';
            const card = document.createElement('div');
            
            card.innerHTML = `
                <div>
                    <div>${course.category_name} • ${typeText}</div>
                    <h3>${course.title}</h3>
                    <div>
                        <div>
                            <div></div>
                        </div>
                        <span>${course.progress}%</span>
                    </div>
                </div>
                <button onclick="alert('Переход к материалам курса!')">
                    Продолжить
                </button>
            `;
            container.appendChild(card);
        });
    } catch (error) {
        console.error("Ошибка загрузки профиля:", error);
        container.innerHTML = '<p>Не удалось загрузить список курсов.</p>';
    }
});