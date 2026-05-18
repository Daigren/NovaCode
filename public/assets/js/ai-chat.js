document.addEventListener('DOMContentLoaded', () => {
    const inputField = document.getElementById('aiInput');
    const sendBtn = document.getElementById('sendAiBtn');
    const chatBox = document.getElementById('chatBox');

    async function sendMessage() {
        const text = inputField.value.trim();
        if (!text) return;

        // 1. Добавляем сообщение пользователя в окно
        appendMessage(text, 'user-message');
        inputField.value = '';

        // 2. Добавляем временное сообщение "ИИ думает..."
        const typingId = 'typing-' + Date.now();
        appendMessage('Анализирую профиль...', 'ai-message', typingId);

        try {
            // 3. Отправляем запрос на наш PHP-сервер
            const response = await fetch('../includes/api/ai-advisor.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });

            const data = await response.json();
            
            // Удаляем сообщение "ИИ думает..."
            document.getElementById(typingId).remove();

            // 4. Выводим ответ нейросети
            if (data.reply) {
                appendMessage(data.reply, 'ai-message');
            } else {
                appendMessage('Ошибка связи с нейросетью.', 'ai-message');
            }

        } catch (error) {
            document.getElementById(typingId).remove();
            appendMessage('Сервер временно недоступен.', 'ai-message');
        }
    }

    function appendMessage(text, className, id = '') {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${className}`;
        msgDiv.textContent = text;
        if (id) msgDiv.id = id;
        chatBox.appendChild(msgDiv);
        chatBox.scrollTop = chatBox.scrollHeight; // Скроллим вниз
    }

    // Отправка по клику и по Enter
    sendBtn.addEventListener('click', sendMessage);
    inputField.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });
});