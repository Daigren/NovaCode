document.addEventListener("DOMContentLoaded", function() {
    const onlineContainer = document.getElementById('onlineCoursesContainer');
    const offlineContainer = document.getElementById('offlineCoursesContainer');
    const searchInput = document.getElementById('searchInput');
    const categoryRadios = document.querySelectorAll('.category-radio');
    const addCourseForm = document.getElementById('addCourseForm');
    const adminMessage = document.getElementById('adminMessage');

    async function fetchCourses() {
        const query = searchInput.value;
        const checkedRadio = document.querySelector('.category-radio:checked');
        const category = checkedRadio ? checkedRadio.value : '';

        try {
            const response = await fetch(`../api/courses.php?q=${encodeURIComponent(query)}&cat=${encodeURIComponent(category)}`);
            const data = await response.json();

            if (data.status === 'success') {
                renderCourses(data.online, onlineContainer, 'Доступно онлайн');
                renderCourses(data.offline, offlineContainer, 'Очное обучение');
            }
        } catch (error) {
            console.error("Ошибка загрузки курсов:", error);
        }
    }

    function renderCourses(coursesArray, container, metaText) {
        container.innerHTML = '';

        if (coursesArray.length === 0) {
            container.innerHTML = '<p style="color: var(--text-secondary); grid-column: 1 / -1;">В этой категории пока нет курсов.</p>';
            return;
        }

        coursesArray.forEach(course => {
            const card = document.createElement('div');
            card.className = 'course-card fade-element visible'; 
            card.innerHTML = `
                <div class="course-badge">${course.category}</div>
                <h3 class="course-title">${course.title}</h3>
                <div class="course-meta">${metaText}</div>
                
                <button onclick="enrollCourse(${course.id})" style="margin-top: 15px; width: 100%; padding: 10px; background: var(--neon-cyan); color: #000; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                    Записаться
                </button>
            `;
            container.appendChild(card);
        });
    }

    if (addCourseForm) {
        addCourseForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const title = document.getElementById('title').value;
            const category = document.getElementById('category').value;
            const type = document.getElementById('type').value;

            try {
                const response = await fetch('../api/courses.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ title, category, type })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    adminMessage.style.color = 'var(--neon-cyan)';
                    adminMessage.innerText = data.message;
                    addCourseForm.reset(); 
                    fetchCourses(); 
                } else {
                    adminMessage.style.color = '#ff4444';
                    adminMessage.innerText = data.message;
                }

                setTimeout(() => adminMessage.innerText = '', 3000);

            } catch (error) {
                console.error("Ошибка добавления курса:", error);
            }
        });
    }

    searchInput.addEventListener('input', fetchCourses);

    categoryRadios.forEach(radio => {
        radio.addEventListener('change', fetchCourses);
    });

    document.getElementById('searchForm').addEventListener('submit', e => e.preventDefault());

    fetchCourses();
});

// ГЛОБАЛЬНАЯ ФУНКЦИЯ ЗАПИСИ НА КУРС
// (вынесена за пределы DOMContentLoaded, чтобы inline-обработчик onclick мог её найти)
window.enrollCourse = async function(courseId) {
    try {
        const response = await fetch('../api/enroll.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ course_id: courseId })
        });
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Ура! ' + data.message + ' Теперь он доступен в вашем профиле.');
        } else {
            alert('Внимание: ' + data.message);
        }
    } catch (error) {
        console.error('Ошибка записи:', error);
        alert('Произошла ошибка при попытке записаться на курс.');
    }
};