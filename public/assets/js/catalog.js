document.addEventListener("DOMContentLoaded", function() {
    const onlineContainer = document.getElementById('onlineCoursesContainer');
    const offlineContainer = document.getElementById('offlineCoursesContainer');
    const searchInput = document.getElementById('searchInput');
    const categoryRadios = document.querySelectorAll('.category-radio');
    const addCourseForm = document.getElementById('addCourseForm');
    const adminMessage = document.getElementById('adminMessage');

    // 1. ФУНКЦИЯ ЗАГРУЗКИ КУРСОВ ИЗ API
    async function fetchCourses() {
        const query = searchInput.value;
        const checkedRadio = document.querySelector('.category-radio:checked');
        const category = checkedRadio ? checkedRadio.value : '';

        try {
            // Отправляем GET запрос с параметрами фильтра
            const response = await fetch(`api/courses.php?q=${encodeURIComponent(query)}&cat=${encodeURIComponent(category)}`);
            const data = await response.json();

            if (data.status === 'success') {
                renderCourses(data.online, onlineContainer, 'Доступно онлайн');
                renderCourses(data.offline, offlineContainer, 'Очное обучение');
            }
        } catch (error) {
            console.error("Ошибка загрузки курсов:", error);
        }
    }

    // 2. ФУНКЦИЯ ОТРИСОВКИ КАРТОЧЕК В HTML
    function renderCourses(coursesArray, container, metaText) {
        container.innerHTML = ''; // Очищаем контейнер

        if (coursesArray.length === 0) {
            container.innerHTML = '<p style="color: var(--text-secondary); grid-column: 1 / -1;">В этой категории пока нет курсов.</p>';
            return;
        }

        coursesArray.forEach(course => {
            const card = document.createElement('div');
            card.className = 'course-card fade-element visible'; // Добавляем visible, чтобы они не скрылись
            card.innerHTML = `
                <div class="course-badge">${course.category}</div>
                <h3 class="course-title">${course.title}</h3>
                <div class="course-meta">${metaText}</div>
            `;
            container.appendChild(card);
        });
    }

    // 3. ДОБАВЛЕНИЕ НОВОГО КУРСА
    if (addCourseForm) {
        addCourseForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const title = document.getElementById('title').value;
            const category = document.getElementById('category').value;
            const type = document.getElementById('type').value;

            try {
                const response = await fetch('api/courses.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ title, category, type })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    adminMessage.style.color = 'var(--neon-cyan)';
                    adminMessage.innerText = data.message;
                    addCourseForm.reset(); // Очищаем форму
                    fetchCourses(); // Автоматически обновляем список курсов!
                } else {
                    adminMessage.style.color = '#ff4444';
                    adminMessage.innerText = data.message;
                }

                // Убираем сообщение через 3 секунды
                setTimeout(() => adminMessage.innerText = '', 3000);

            } catch (error) {
                console.error("Ошибка добавления курса:", error);
            }
        });
    }

    // 4. СЛУШАТЕЛИ ДЛЯ ПОИСКА И ФИЛЬТРОВ (Динамическое обновление)
    
    // Обновляем курсы при каждом вводе символа в строку поиска
    searchInput.addEventListener('input', fetchCourses);

    // Обновляем курсы при переключении радио-кнопок категорий
    categoryRadios.forEach(radio => {
        radio.addEventListener('change', fetchCourses);
    });

    // Остановка стандартной отправки формы поиска при нажатии Enter
    document.getElementById('searchForm').addEventListener('submit', e => e.preventDefault());

    // 5. ПЕРВИЧНАЯ ЗАГРУЗКА ПРИ ОТКРЫТИИ СТРАНИЦЫ
    fetchCourses();
});